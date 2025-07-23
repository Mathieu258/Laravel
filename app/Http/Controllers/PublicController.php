<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use App\Models\Produit;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Affiche la liste des stands approuvés (page publique)
     */
    public function index(Request $request)
    {
        $query = Stand::with(['user', 'produits'])
            ->whereHas('user', function($q) {
                $q->where('role', 'entrepreneur')
                  ->where('statut', 'approuve');
            });

        // Recherche par nom de stand ou nom d'entreprise
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom_stand', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filtre par catégorie (si implémenté plus tard)
        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        $stands = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $stands,
            'message' => 'Stands récupérés avec succès'
        ]);
    }

    /**
     * Affiche les détails d'un stand avec ses produits
     */
    public function show($id)
    {
        $stand = Stand::with(['user', 'produits' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])
        ->whereHas('user', function($q) {
            $q->where('role', 'entrepreneur')
              ->where('statut', 'approuve');
        })
        ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $stand,
            'message' => 'Stand récupéré avec succès'
        ]);
    }

    /**
     * Recherche de produits dans tous les stands approuvés
     */
    public function searchProduits(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:2|max:100',
        ]);

        $produits = Produit::with(['stand.user'])
            ->whereHas('stand.user', function($q) {
                $q->where('role', 'entrepreneur')
                  ->where('statut', 'approuve');
            })
            ->where(function($q) use ($request) {
                $q->where('nom', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $produits,
            'message' => 'Produits trouvés avec succès'
        ]);
    }

    /**
     * Récupère les statistiques publiques
     */
    public function stats()
    {
        $stats = [
            'total_stands' => Stand::whereHas('user', function($q) {
                $q->where('role', 'entrepreneur')->where('statut', 'approuve');
            })->count(),
            'total_produits' => Produit::whereHas('stand.user', function($q) {
                $q->where('role', 'entrepreneur')->where('statut', 'approuve');
            })->count(),
            'total_entrepreneurs' => \App\Models\User::where('role', 'entrepreneur')
                ->where('statut', 'approuve')->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'message' => 'Statistiques récupérées avec succès'
        ]);
    }
}
