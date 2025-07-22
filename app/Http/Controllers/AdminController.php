<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    }
}
