@extends('app')

@section('content')
<div class="container">
    <h1>Mes produits</h1>
    <a href="{{ route('entrepreneur.products.create') }}" class="btn btn-primary">Ajouter un produit</a>

    <div class="card mt-3">
        <div class="card-header">
            <h2>Liste des produits</h2>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img src="{{ asset('images/1753008821.jpg') }}" alt="Image" width="100">
                        </td>
                        <td>Produit 1</td>
                        <td>Description du produit</td>
                        <td>1000 XOF</td>
                        <td>
                            <a href="{{ route('entrepreneur.products.edit', 1) }}" class="btn btn-warning">Modifier</a>
                            <button class="btn btn-danger">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
