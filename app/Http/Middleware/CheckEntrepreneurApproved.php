<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEntrepreneurApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->role === 'entrepreneur' && $user->statut !== 'approuve') {
            // Bloquer seulement si ce n'est pas déjà la page de statut
            if (!$request->routeIs('statut.demande')) {
                return redirect()->route('statut.demande');
            }
        }
        return $next($request);
    }
}
