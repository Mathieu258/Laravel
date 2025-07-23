<?php

namespace App\Http\Controllers;

 develop
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

use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $produitId => $quantity) {
            $produit = Produit::with('stand.user')
                ->whereHas('stand.user', function($q) {
                    $q->where('role', 'entrepreneur')
                      ->where('statut', 'approuve');
                })
                ->find($produitId);

            if ($produit) {
                $cartItems[] = [
                    'produit' => $produit,
                    'quantite' => $quantity,
                    'sous_total' => $produit->prix * $quantity
                ];
                $total += $produit->prix * $quantity;
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $cartItems,
                'total' => $total,
                'count' => count($cartItems)
            ],
            'message' => 'Panier récupéré avec succès'
        ]);
    }

    /**
     * Ajoute un produit au panier
     */
    public function add(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1|max:100',
        ]);

        $produit = Produit::with('stand.user')
            ->whereHas('stand.user', function($q) {
                $q->where('role', 'entrepreneur')
                  ->where('statut', 'approuve');
            })
            ->findOrFail($request->produit_id);

        $cart = Session::get('cart', []);
        $produitId = $request->produit_id;

        if (isset($cart[$produitId])) {
            $cart[$produitId] += $request->quantite;
        } else {
            $cart[$produitId] = $request->quantite;
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'data' => [
                'produit' => $produit,
                'quantite' => $cart[$produitId],
                'message' => 'Produit ajouté au panier'
            ]
        ]);
    }

    /**
     * Met à jour la quantité d'un produit dans le panier
     */
    public function update(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:0|max:100',
        ]);

        $cart = Session::get('cart', []);
        $produitId = $request->produit_id;

        if ($request->quantite == 0) {
            unset($cart[$produitId]);
        } else {
            $cart[$produitId] = $request->quantite;
        }

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'data' => [
                'quantite' => $request->quantite,
                'message' => $request->quantite == 0 ? 'Produit supprimé du panier' : 'Quantité mise à jour'
            ]
        ]);
    }

    /**
     * Supprime un produit du panier
     */
    public function remove($produitId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$produitId])) {
            unset($cart[$produitId]);
            Session::put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'message' => 'Produit supprimé du panier'
            ]
        ]);
    }

    /**
     * Vide complètement le panier
     */
    public function clear()
    {
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'data' => [
                'message' => 'Panier vidé avec succès'
            ]
        ]);
    }

    /**
     * Récupère le nombre d'articles dans le panier
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $count = array_sum($cart);

        return response()->json([
            'success' => true,
            'data' => [
                'count' => $count
            ]
        ]);
 master
    }
}
