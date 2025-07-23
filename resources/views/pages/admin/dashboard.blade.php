@extends('app')

@section('content')
<div class="container">
    <h1>Tableau de bord de l'administrateur</h1>
    <p>Bienvenue, John Doe!</p>

    <div class="card">
        <div class="card-header">
            <h2>Demandes de stand en attente</h2>
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
                        <th>Nom de l'entreprise</th>
                        <th>Nom du contact</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Societe General</td>
                        <td>John Doe</td>
                        <td>john@doe.com</td>
                        <td>
                            <button class="btn btn-success">Approuver</button>
                            <button class="btn btn-danger">Rejeter</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
