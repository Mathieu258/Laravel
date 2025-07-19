<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Ici tu peux retourner une vue ou des données pour le dashboard admin
        return view('admin.dashboard');
    }
}
