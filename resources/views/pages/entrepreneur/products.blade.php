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
                    @forelse ($products as $product)
                        <tr>
                            <td>
                                @if($product->image_url)
                                    <img src="{{ asset('images/' . $product->image_url) }}" alt="{{ $product->name }}" width="100">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }} €</td>
                            <td>
                                <a href="{{ route('entrepreneur.products.edit', $product) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('entrepreneur.products.delete', $product) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Vous n'avez aucun produit.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
