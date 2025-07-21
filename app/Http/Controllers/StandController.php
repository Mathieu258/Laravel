<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use Illuminate\Http\Request;

class StandController extends Controller
{
    public function __construct()
    {
        // Middleware supprimé pour laisser les policies gérer l'accès
    }

    // Affiche la liste des stands avec recherche et pagination
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Stand::query();

        // Si l'utilisateur est entrepreneur approuvé, il ne voit que ses stands
        if (auth()->user()->role === 'entrepreneur' && auth()->user()->statut === 'approuve') {
            $query->where('user_id', auth()->id());
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nom_stand', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        $stands = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('stands.index', compact('stands', 'search'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        $this->authorize('create', Stand::class);
        return view('stands.create');
    }

    // Enregistre un nouveau stand
    public function store(Request $request)
    {
        $request->validate([
            'nom_stand' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        Stand::create([
            'nom_stand' => $request->input('nom_stand'),
            'description' => $request->input('description'),
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('stands.index')->with('success', 'Stand créé avec succès.');
    }

    // Affiche le détail d'un stand
    public function show(Stand $stand)
    {
        $this->authorize('view', $stand);
        return view('stands.show', compact('stand'));
    }

    // Affiche le formulaire d'édition
    public function edit(Stand $stand)
    {
        $this->authorize('update', $stand);
        return view('stands.edit', compact('stand'));
    }

    // Met à jour un stand
    public function update(Request $request, Stand $stand)
    {
        $this->authorize('update', $stand);
        $request->validate([
            'nom_stand' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $stand->update($request->only('nom_stand', 'description'));
        return redirect()->route('stands.index')->with('success', 'Stand mis à jour avec succès.');
    }

    // Supprime un stand
    public function destroy(Stand $stand)
    {
        $this->authorize('delete', $stand);
        $stand->delete();
        return redirect()->route('stands.index')->with('success', 'Stand supprimé avec succès.');
    }
} 