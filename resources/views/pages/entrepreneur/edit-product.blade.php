@extends('app')

@section('content')
<div class="container">
    <h1>Modifier le produit</h1>

    <div class="card">
        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nom du produit</label>
                    <input type="text" name="name" id="name" class="form-control" value="Product 1" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" required>Description du produit</textarea>
                </div>
                <div class="form-group">
                    <label for="price">Prix</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" value="1000" required>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if($product->image_url)
                        <img src="{{ asset('images/1753008641.jpg') }}" alt="Image" width="100" class="mt-2">
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>
</div>
@endsection
