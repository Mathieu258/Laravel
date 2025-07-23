@extends('auth')

@section('auth')
    <section class="login p-fixed d-flex text-center bg-secondary">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="signup-card card-block auth-body mr-auto ml-auto">
                        <form class="md-float-material form-material" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="text-center">
                                <h1 class="text-white">Bienvenue sur Eat&Drink</h1>
                            </div>
                            <div class="auth-box">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Demande de stand</h3>
                                    </div>
                                </div>
                                <hr/>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" placeholder="Votre nom" required>
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="text" name="company_name" class="form-control" placeholder="Nom de l'entreprise" required>
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control" placeholder="Votre adresse e-mail" required>
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                                    <span class="md-line"></span>
                                </div>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmez le mot de passe" required>
                                    <span class="md-line"></span>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">S'inscrire</button>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-inverse text-left m-b-0">Merci.</p>
                                        <p class="text-inverse text-left"><a href="{{ url('/login') }}"><b>Déjà inscrit?</b></a></p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
