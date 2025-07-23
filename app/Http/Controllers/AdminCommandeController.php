<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Stand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCommandeController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les paramètres de filtrage
        $search = $request->input('search');
        $standFilter = $request->input('stand');
        $statusFilter = $request->input('status');
        $dateFilter = $request->input('date');

        // Requête de base pour les commandes avec relations
        $commandes = Commande::with(['stand', 'produit'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nom_client', 'like', "%{$search}%")
                      ->orWhere('email_client', 'like', "%{$search}%")
                      ->orWhere('telephone_client', 'like', "%{$search}%")
                      ->orWhereHas('stand', function ($standQuery) use ($search) {
                          $standQuery->where('nom_stand', 'like', "%{$search}%");
                      })
                      ->orWhereHas('produit', function ($produitQuery) use ($search) {
                          $produitQuery->where('nom', 'like', "%{$search}%");
                      });
                });
            })
            ->when($standFilter, function ($query, $standFilter) {
                $query->where('stand_id', $standFilter);
            })
            ->when($statusFilter, function ($query, $statusFilter) {
                $query->where('statut', $statusFilter);
            })
            ->when($dateFilter, function ($query, $dateFilter) {
                $query->whereDate('created_at', $dateFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistiques globales
        $stats = [
            'total_commandes' => Commande::count(),
            'total_ca' => Commande::sum(DB::raw('prix * quantite')),
            'commandes_en_attente' => Commande::where('statut', 'en_attente')->count(),
            'commandes_confirmees' => Commande::where('statut', 'confirmee')->count(),
            'commandes_livrees' => Commande::where('statut', 'livree')->count(),
        ];

        // Statistiques par stand
        $statsParStand = Stand::withCount(['commandes'])
            ->withSum(['commandes' => function ($query) {
                $query->select(DB::raw('prix * quantite'));
            }], 'prix')
            ->get()
            ->map(function ($stand) {
                return [
                    'id' => $stand->id,
                    'nom' => $stand->nom_stand,
                    'nb_commandes' => $stand->commandes_count,
                    'ca_total' => $stand->commandes_sum_prix ?? 0,
                    'ca_moyen' => $stand->commandes_count > 0 ? round(($stand->commandes_sum_prix ?? 0) / $stand->commandes_count, 2) : 0,
                ];
            })
            ->sortByDesc('ca_total');

        // Liste des stands pour le filtre
        $stands = Stand::orderBy('nom_stand')->get();

        // Liste des statuts pour le filtre
        $statuts = [
            'en_attente' => 'En attente',
            'confirmee' => 'Confirmée',
            'livree' => 'Livrée',
            'annulee' => 'Annulée'
        ];

        return view('admin.commandes', compact(
            'commandes',
            'stats',
            'statsParStand',
            'stands',
            'statuts',
            'search',
            'standFilter',
            'statusFilter',
            'dateFilter'
        ));
    }

    public function show(Commande $commande)
    {
        $commande->load(['stand', 'produit']);
        return view('admin.commandes.show', compact('commande'));
    }

    public function updateStatus(Request $request, Commande $commande)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,confirmee,livree,annulee'
        ]);

        $commande->update([
            'statut' => $request->statut
        ]);

        return redirect()->back()->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    public function export(Request $request)
    {
        // Export des commandes (format CSV ou Excel)
        $commandes = Commande::with(['stand', 'produit'])
            ->when($request->input('stand'), function ($query, $stand) {
                $query->where('stand_id', $stand);
            })
            ->when($request->input('date'), function ($query, $date) {
                $query->whereDate('created_at', $date);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'commandes_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($commandes) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Stand', 'Produit', 'Client', 'Email', 'Téléphone', 
                'Quantité', 'Prix unitaire', 'Total', 'Statut', 'Date commande'
            ]);

            // Données
            foreach ($commandes as $commande) {
                fputcsv($file, [
                    $commande->id,
                    $commande->stand->nom_stand,
                    $commande->produit->nom,
                    $commande->nom_client,
                    $commande->email_client,
                    $commande->telephone_client,
                    $commande->quantite,
                    $commande->prix,
                    $commande->prix * $commande->quantite,
                    $commande->statut,
                    $commande->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 