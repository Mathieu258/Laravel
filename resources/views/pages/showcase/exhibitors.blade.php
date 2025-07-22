@extends('app')

@section('content')
<div class="container">
    <h1>Nos exposants</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Stand 1</h5>
                    <p class="card-text">Stad description</p>
                    <a href="{{ route('stand', 1) }}" class="btn btn-primary">Voir le stand</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Stand 2</h5>
                    <p class="card-text">Stad description</p>
                    <a href="{{ route('stand', 1) }}" class="btn btn-primary">Voir le stand</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
