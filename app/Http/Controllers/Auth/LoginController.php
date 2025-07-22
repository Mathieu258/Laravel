<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $role = 'admin'; // contractor_approved, contractor_pending

        if ($role === 'admin') {

            return redirect()->intended('/admin/dashboard');
        } elseif ($role === 'contractor_approved') {
            return redirect()->intended('/entrepreneur/dashboard');
        } elseif ($role === 'contractor_pending') {
            return back()->withErrors([
                'email' => 'Votre compte est en attente d\'approbation.',
            ]);
        } else {
            return back()->withErrors([
                'email' => 'Accès non autorisé.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function logout(Request $request)
    {
        // Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
