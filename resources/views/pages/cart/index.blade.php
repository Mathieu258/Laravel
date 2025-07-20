@extends('app')

@section('content')
<div class="container">
    <h1>Votre panier</h1>

    @if(empty($cart))
        <p>Votre panier est vide.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0 @endphp
                @foreach($cart as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr>
                        <td>
                            @if($details['image_url'])
                                <img src="{{ asset('images/' . $details['image_url']) }}" width="50" alt="{{ $details['name'] }}">
                            @endif
                        </td>
                        <td>{{ $details['name'] }}</td>
                        <td>{{ $details['price'] }} €</td>
                        <td>{{ $details['quantity'] }}</td>
                        <td>{{ $details['price'] * $details['quantity'] }} €</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">x</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                    <td><strong>{{ $total }} €</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <form action="{{ route('cart.placeOrder') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Passer la commande</button>
        </form>
    @endif
</div>
@endsection
