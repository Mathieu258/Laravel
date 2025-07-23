@extends('app')

@section('content')
<div class="container">
    <h1>Stand 1</h1>
    <p>Description stand</p>
    <p><strong>Contact:</strong> John Doe (john@doe.com)</p>

    <hr>

    <h2>Nos produits</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ asset('images/1753008821.jpg') }}" class="card-img-top" alt="Image">
                <div class="card-body">
                    <h5 class="card-title">Produit 1</h5>
                    <p class="card-text">Description du produit</p>
                    <p class="card-text"><strong>Prix:</strong> 1000 XOF</p>
                    <button class="btn btn-primary">Ajouter au panier</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
