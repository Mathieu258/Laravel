<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        $products = Auth::user()->stand->products;
        return view('pages.entrepreneur.products', compact('products'));
    }

    public function createProduct()
    {
        return view('pages.entrepreneur.create-product');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        Auth::user()->stand->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $imageName,
        ]);

        return redirect()->route('entrepreneur.products')->with('success', 'Produit ajouté avec succès.');
    }

    public function editProduct(Product $product)
    {
        return view('pages.entrepreneur.edit-product', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = $product->image_url;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $imageName,
        ]);

        return redirect()->route('entrepreneur.products')->with('success', 'Produit mis à jour avec succès.');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('entrepreneur.products')->with('success', 'Produit supprimé avec succès.');
    }
}
