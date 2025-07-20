@extends('app')

@section('content')
<div class="container">
    <h1>Tableau de bord de l'administrateur</h1>
    <p>Bienvenue, {{ Auth::user()->name }}!</p>

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
                    @forelse ($pendingRequests as $request)
                        <tr>
                            <td>{{ $request->company_name }}</td>
                            <td>{{ $request->name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>
                                <form action="{{ route('admin.approve', $request) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Approuver</button>
                                </form>
                                <form action="{{ route('admin.reject', $request) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Rejeter</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Aucune demande en attente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
