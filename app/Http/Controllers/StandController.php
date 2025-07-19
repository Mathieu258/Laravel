<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use Illuminate\Http\Request;

class StandController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Accès refusé.');
            }
            return $next($request);
        });
    }

    // Affiche la liste des stands avec recherche et pagination
    public function index(Request $request)
    {
        $search = $request->input('search');
        $stands = Stand::query()
            ->when($search, function ($query, $search) {
                $query->where('nom', 'like', "%$search%")
                      ->orWhere('description', 'like', "%$search%") ;
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        return view('stands.index', compact('stands', 'search'));
    }

    // Affiche le formulaire de création
    public function create()
    {
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
        return view('stands.show', compact('stand'));
    }

    // Affiche le formulaire d'édition
    public function edit(Stand $stand)
    {
        return view('stands.edit', compact('stand'));
    }

    // Met à jour un stand
    public function update(Request $request, Stand $stand)
    {
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
        $stand->delete();
        return redirect()->route('stands.index')->with('success', 'Stand supprimé avec succès.');
    }
} 