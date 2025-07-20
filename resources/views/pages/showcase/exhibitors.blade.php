@extends('app')

@section('content')
<div class="container">
    <h1>Nos exposants</h1>

    <div class="row">
        @forelse ($stands as $stand)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $stand->stand_name }}</h5>
                        <p class="card-text">{{ $stand->description }}</p>
                        <a href="{{ route('stand', $stand) }}" class="btn btn-primary">Voir le stand</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <p>Il n'y a aucun exposant pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
