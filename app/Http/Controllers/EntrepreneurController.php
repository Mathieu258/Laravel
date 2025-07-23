<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntrepreneurController extends Controller
{
    public function dashboard()
    {
        return view('pages.entrepreneur.dashboard');
    }

    public function products()
    {
        return view('pages.entrepreneur.products');
    }

    public function createProduct()
    {
        return view('pages.entrepreneur.create-product');
    }

    public function storeProduct(Request $request)
    {
        return redirect()->route('entrepreneur.products')->with('success', 'Produit ajouté avec succès.');
    }

    public function editProduct($product)
    {
        return view('pages.entrepreneur.edit-product');
    }

    public function updateProduct(Request $request, $product)
    {
        return redirect()->route('entrepreneur.products')->with('success', 'Produit mis à jour avec succès.');
    }

    public function deleteProduct($product)
    {
        return redirect()->route('entrepreneur.products')->with('success', 'Produit supprimé avec succès.');
    }
}
