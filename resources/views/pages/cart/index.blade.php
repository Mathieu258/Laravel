@extends('app')

@section('content')
<div class="container">
    <h1>Votre panier</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <img src="{{ asset('images/1753008821.jpg') }}" width="50" alt="Image">
                </td>
                <td>Product 1</td>
                <td>1000 XOF</td>
                <td>12</td>
                <td>12 000 XOF</td>
                <td>
                    <button class="btn btn-danger btn-sm">x</button>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td><strong>12 000 XOF</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <button class="btn btn-success">Passer la commande</button>
</div>
@endsection
