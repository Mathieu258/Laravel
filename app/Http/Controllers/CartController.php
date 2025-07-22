<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        return view('pages.cart.index');
    }

    public function add(Request $request, $product)
    {

        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès!');
    }

    public function remove(Product $product)
    {
        return redirect()->back()->with('success', 'Produit retiré du panier avec succès!');
    }

    public function placeOrder(Request $request)
    {
        return redirect()->route('exhibitors')->with('success', 'Votre commande a été passée avec succès.');
    }
}
