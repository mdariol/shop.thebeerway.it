@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('invalid_cart'))
            <div class="alert alert-warning">
                {{ session('invalid_cart') }}
            </div>
        @endif

        <h1>Carrello</h1>

        <cart :cart='@json($cart)' :edit='@json(true)'></cart>

        @if( ! $cart->isEmpty())
            <a href="{{ route('checkout.show') }}" class="btn btn-primary" id="purchase">Ordina</a>
        @endif
    </div>
@endsection
