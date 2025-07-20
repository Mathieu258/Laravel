<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingRequests = User::where('role', 'contractor_pending')->get();
        return view('pages.admin.dashboard', compact('pendingRequests'));
    }

    public function approve(User $user)
    {
        $user->update(['role' => 'contractor_approved']);
        // Here you should also create a stand for the user
        $stand = new \App\Models\Stand([
            'stand_name' => $user->company_name,
            'description' => 'Bienvenue sur notre stand!',
            'user_id' => $user->id,
        ]);
        $stand->save();
        return redirect()->route('admin.dashboard')->with('success', 'La demande a été approuvée.');
    }

    public function reject(User $user, Request $request)
    {
        // For simplicity, we'll just delete the user.
        // A better approach would be to add a 'rejected_reason' column to the users table
        // and notify the user.
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'La demande a été rejetée.');
    }
}
