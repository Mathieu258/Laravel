@extends('app')

@section('content')
<div class="container">
    <h1>{{ $stand->stand_name }}</h1>
    <p>{{ $stand->description }}</p>
    <p><strong>Contact:</strong> {{ $stand->user->name }} ({{ $stand->user->email }})</p>

    <hr>

    <h2>Nos produits</h2>
    <div class="row">
        @forelse ($stand->products as $product)
            <div class="col-md-4">
                <div class="card mb-4">
                    @if($product->image_url)
                        <img src="{{ asset('images/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>Prix:</strong> {{ $product->price }} €</p>
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p>Ce stand n'a aucun produit pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
