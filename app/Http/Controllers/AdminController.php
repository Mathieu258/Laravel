<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 develop

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('pages.admin.dashboard');
    }

    public function approve($user)
    {
        return redirect()->route('admin.dashboard')->with('success', 'La demande a été approuvée.');
    }

    public function reject($user, Request $request)
    {
        return redirect()->route('admin.dashboard')->with('success', 'La demande a été rejetée.');

use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Statistiques principales
        $totalUsers = \App\Models\User::count();
        $totalEntrepreneursAttente = \App\Models\User::where('role', 'entrepreneur_en_attente')->count();
        $totalEntrepreneursApprouves = \App\Models\User::where('role', 'entrepreneur_approuve')->count();
        $totalStands = \App\Models\Stand::count();
        $totalProduits = \App\Models\Produit::count();
        $totalCommandes = \App\Models\Commande::count();

        // 5 dernières demandes d'entrepreneurs en attente
        $dernieresDemandes = \App\Models\User::where('role', 'entrepreneur_en_attente')->orderBy('created_at', 'desc')->take(5)->get();

        // 5 dernières commandes
        $dernieresCommandes = \App\Models\Commande::orderBy('created_at', 'desc')->take(5)->get();

        // Commandes par mois (12 derniers mois)
        $commandesParMois = [];
        $labelsMois = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labelsMois[] = $date->format('M Y');
            $commandesParMois[] = \App\Models\Commande::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Répartition des rôles utilisateurs (camembert)
        $roles = [
            'Admin' => \App\Models\User::where('role', 'admin')->count(),
            'Entrepreneurs approuvés' => \App\Models\User::where('role', 'entrepreneur_approuve')->count(),
            'Entrepreneurs en attente' => \App\Models\User::where('role', 'entrepreneur_en_attente')->count(),
            'Participants' => \App\Models\User::where('role', 'participant')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEntrepreneursAttente',
            'totalEntrepreneursApprouves',
            'totalStands',
            'totalProduits',
            'totalCommandes',
            'dernieresDemandes',
            'dernieresCommandes',
            'labelsMois',
            'commandesParMois',
            'roles'
        ));
 master
    }
}
