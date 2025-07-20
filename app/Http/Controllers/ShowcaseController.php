<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    public function exhibitors()
    {
        $stands = Stand::with('user')->whereHas('user', function ($query) {
            $query->where('role', 'contractor_approved');
        })->get();
        return view('pages.showcase.exhibitors', compact('stands'));
    }

    public function stand(Stand $stand)
    {
        $stand->load('products');
        return view('pages.showcase.stand', compact('stand'));
    }
}
