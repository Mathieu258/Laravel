<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function checkAdminRole()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès refusé.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkAdminRole();
        
        $query = Produit::with('stand');

        // Recherche par nom
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filtre par stand
        if ($request->filled('stand_id')) {
            $query->where('stand_id', $request->stand_id);
        }

        $produits = $query->orderBy('created_at', 'desc')->paginate(10);
        $stands = Stand::all();

        return view('produits.index', compact('produits', 'stands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAdminRole();
        
        $stands = Stand::all();
        return view('produits.create', compact('stands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAdminRole();
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stand_id' => 'required|exists:stands,id'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/produits'), $imageName);
            $data['image'] = $imageName;
        }

        Produit::create($data);

        return redirect()->route('produits.index')
            ->with('success', 'Produit créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produit $produit)
    {
        $this->checkAdminRole();
        
        return view('produits.show', compact('produit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produit $produit)
    {
        $this->checkAdminRole();
        
        $stands = Stand::all();
        return view('produits.edit', compact('produit', 'stands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produit $produit)
    {
        $this->checkAdminRole();
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stand_id' => 'required|exists:stands,id'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($produit->image && file_exists(public_path('images/produits/' . $produit->image))) {
                unlink(public_path('images/produits/' . $produit->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/produits'), $imageName);
            $data['image'] = $imageName;
        }

        $produit->update($data);

        return redirect()->route('produits.index')
            ->with('success', 'Produit mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produit $produit)
    {
        $this->checkAdminRole();
        
        $produit->delete();

        return redirect()->route('produits.index')
            ->with('success', 'Produit supprimé avec succès !');
    }
}
