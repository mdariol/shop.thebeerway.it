@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina l'indirizzo <em>{{ $shippingAddress->name }}</em></h1>
        <form method="POST" action="{{ route('billing-profiles.shipping-addresses.destroy', ['billing_profile' => $billingProfile->id, 'shipping_address' => $shippingAddress->id]) }}">
            @csrf
            @method('DELETE')

            <p>Sei sicuro di voler eliminare {{ $shippingAddress->name }}? Questa azione è <em>irreversibile</em>.</p>
            <button type="submit" class="btn btn-primary">Elimina</button>
            <a href="{{ route('billing-profiles.show', ['billing_profile' => $billingProfile->id]) }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
