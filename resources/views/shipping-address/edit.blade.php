@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuovo</em> Indirizzo di Spedizione</h1>

        <form method="POST" action="{{ route('shipping-addresses.update', ['company' => $company->id, 'shipping_address' => $shippingAddress->id]) }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Mario Rossi"
                       required value="{{ $shippingAddress->name }}">
            </div>

            <place :value='@json($shippingAddress->address)'></place>

            <div class="form-group">
                <label for="phone">Telefono</label>
                <input type="tel" name="phone" class="form-control" id="phone" required
                       pattern="^[0-9 ]*$" value="{{ $shippingAddress->phone }}">
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('shipping-addresses.delete', ['company' => $company->id, 'shipping_address' => $shippingAddress->id]) }}" class="btn btn-link">Elimina</a>
        </form>
    </div>
@endsection
