@extends('app')

@section('content')
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center">
                                <h1>Bienvenue sur notre plateforme!</h1>
                                <p>Découvrez nos exposants et leurs produits.</p>
                                <a href="{{ route('exhibitors') }}" class="btn btn-primary">Voir les exposants</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
