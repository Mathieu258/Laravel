<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Stand;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function __construct()
    {
        // Temporairement, on va déplacer la vérification dans chaque méthode
        // pour éviter les problèmes de session
    }

    /**
     * Afficher la liste des commandes
     */
    public function index(Request $request)
    {
        if (!auth()->check()) {
            abort(401, 'Vous devez être connecté.');
        }

        $query = Commande::with(['stand', 'user']);

        // Filtrage par statut
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtrage par stand (pour les entrepreneurs approuvés)
        if (auth()->user()->role === 'entrepreneur' && auth()->user()->statut === 'approuve') {
            $query->whereHas('stand', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        // Recherche par nom de stand
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('stand', function ($q) use ($search) {
                $q->where('nom_stand', 'like', "%{$search}%");
            });
        }

        $commandes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('commandes.index', compact('commandes'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $stands = Stand::all();
        $produits = Produit::with('stand')->get();
        
        // Grouper les produits par stand pour le JavaScript
        $produitsParStand = $produits->groupBy('stand_id');
        
        return view('commandes.create', compact('stands', 'produits', 'produitsParStand'));
    }

    /**
     * Enregistrer une nouvelle commande
     */
    public function store(Request $request)
    {
        $request->validate([
            'stand_id' => 'required|exists:stands,id',
            'produits' => 'required|array|min:1',
            'quantites' => 'required|array|min:1',
            // autres validations si besoin
        ]);

        try {
            DB::beginTransaction();

            $commande = new Commande();
            $commande->stand_id = $request->stand_id;
            $commande->user_id = auth()->id();
            $commande->statut = 'en_attente';
            $commande->notes = $request->notes;

            // Stocker les détails sous forme de tableau associatif ou JSON
            $details = [];
            $total = 0;
            foreach ($request->produits as $i => $produit_id) {
                $quantite = $request->quantites[$i];
                $details[] = [
                    'produit_id' => $produit_id,
                    'quantite' => $quantite
                ];
                $produit = \App\Models\Produit::find($produit_id);
                if ($produit) {
                    $total += $produit->prix * $quantite;
                }
            }
            $commande->details_commande = $details;
            $commande->total_prix = $total;
            $commande->save();

            DB::commit();

            return redirect()->route('commandes.index')->with('success', 'Commande créée avec succès !');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erreur lors de la création de la commande.');
        }
    }

    /**
     * Afficher une commande
     */
    public function show(Commande $commande)
    {
        // Décoder les détails de la commande
        $details = is_string($commande->details_commande)
            ? json_decode($commande->details_commande, true)
            : $commande->details_commande;

        // Récupérer les produits avec leurs quantités
        $produits = collect();
        $total = 0;
        if (is_array($details)) {
            foreach ($details as $item) {
                $produit = \App\Models\Produit::find($item['produit_id']);
                if ($produit) {
                    $quantite = $item['quantite'];
                    $sousTotal = $produit->prix * $quantite;
                    $produit->quantite_commande = $quantite;
                    $produit->sous_total = $sousTotal;
                    $total += $sousTotal;
                    $produits->push($produit);
                }
            }
        }

        return view('commandes.show', compact('commande', 'produits', 'total'));
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Commande $commande)
    {
        // Vérifier les permissions
        if (auth()->user()->role === 'entrepreneur' && auth()->user()->statut === 'approuve') {
            if ($commande->stand->user_id !== auth()->id()) {
                abort(403, 'Accès refusé.');
            }
        }

        $stands = Stand::all();
        $produits = Produit::with('stand')->get();
        $commande->load(['stand', 'user']);
        
        // Grouper les produits par stand pour le JavaScript
        $produitsParStand = $produits->groupBy('stand_id');

        return view('commandes.edit', compact('commande', 'stands', 'produits', 'produitsParStand'));
    }

    /**
     * Mettre à jour une commande
     */
    public function update(Request $request, Commande $commande)
    {
        // Vérifier les permissions
        if (auth()->user()->role === 'entrepreneur' && auth()->user()->statut === 'approuve') {
            if ($commande->stand->user_id !== auth()->id()) {
                abort(403, 'Accès refusé.');
            }
        }

        $request->validate([
            'stand_id' => 'required|exists:stands,id',
            'details_commande' => 'required|array',
            'details_commande.produits' => 'required|array',
            'statut' => 'required|in:en_attente,confirmee,en_preparation,livree,annulee',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $commande->stand_id = $request->stand_id;
            $commande->details_commande = $request->details_commande;
            $commande->statut = $request->statut;
            $commande->notes = $request->notes;
            $commande->save();

            // Recalculer le total
            $total = $commande->calculerTotal();
            $commande->total_prix = $total;
            $commande->save();

            DB::commit();

            return redirect()->route('commandes.index')
                ->with('success', 'Commande mise à jour avec succès !');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erreur lors de la mise à jour de la commande.');
        }
    }

    /**
     * Supprimer une commande
     */
    public function destroy(Commande $commande)
    {
        // Vérifier les permissions
        if (auth()->user()->role === 'entrepreneur' && auth()->user()->statut === 'approuve') {
            if ($commande->stand->user_id !== auth()->id()) {
                abort(403, 'Accès refusé.');
            }
        }

        try {
            $commande->delete();
            return redirect()->route('commandes.index')
                ->with('success', 'Commande supprimée avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression de la commande.');
        }
    }

    /**
     * Changer le statut d'une commande
     */
    public function updateStatut(Request $request, Commande $commande)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,en_preparation,livree,annulee',
        ]);

        $commande->statut = $request->statut;
        $commande->save();

        return back()->with('success', 'Statut de la commande mis à jour !');
    }
} 