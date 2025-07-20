@extends('app')

@section('content')
<div class="container">
    <h1>Tableau de bord de l'entrepreneur</h1>
    <p>Bienvenue, {{ Auth::user()->name }}!</p>

    <div class="card">
        <div class="card-header">
            <h2>Mon stand</h2>
        </div>
        <div class="card-body">
            <p><strong>Nom du stand:</strong> {{ Auth::user()->stand?->stand_name }}</p>
            <p><strong>Description:</strong> {{ Auth::user()->stand?->description }}</p>
            <a href="{{ route('entrepreneur.products') }}" class="btn btn-primary">Gérer mes produits</a>
        </div>
    </div>
</div>
@endsection
