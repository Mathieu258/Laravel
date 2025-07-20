<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Affiche la liste des entrepreneurs en attente
    public function index()
    {
        $demandes = User::where('role', 'entrepreneur')
            ->where('statut', 'en_attente')
            ->get();
        return view('admin.demandes', compact('demandes'));
    }

    // Approuve ou rejette une demande
    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:approuve,rejete',
        ]);
        $user = User::findOrFail($id);
        $user->statut = $request->statut;
        $user->save();
        return redirect()->route('admin.demandes')->with('success', 'Statut mis à jour.');
    }
}
