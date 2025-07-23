<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowcaseController extends Controller
{
    public function exhibitors()
    {
        return view('pages.showcase.exhibitors');
    }

    public function stand($stand)
    {
        return view('pages.showcase.stand');
    }
}
