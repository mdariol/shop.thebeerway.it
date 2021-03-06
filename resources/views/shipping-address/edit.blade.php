@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuovo</em> Indirizzo di Spedizione</h1>

        <form method="POST" action="{{ route('billing-profiles.shipping-addresses.update', ['billing_profile' => $billingProfile->id, 'shipping_address' => $shippingAddress->id]) }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Mario Rossi" value="{{ $shippingAddress->name }}"
                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <place :address='@json($shippingAddress)'></place>

            <div class="form-group">
                <label for="phone">Telefono <span class="text-muted">(Opzionale)</span></label>
                <input type="tel" name="phone" id="phone" pattern="^\+?[0-9 ]*" value="{{ $shippingAddress->phone }}"
                       class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                @else
                    <small class="text-muted">Verrà usato per eventuali comunicazioni sulla consegna.</small>
                @endif
            </div>

            <div class="form-group custom-control custom-switch">
                <input type="checkbox" name="is_default" id="is-default" class="custom-control-input"
                    {{ $shippingAddress->is_default ? 'checked' : '' }}>
                <label class="custom-control-label" for="is-default">Indirizzo predefinito</label>
                <small class="form-text text-muted">Verrà utilizzato come indirizzo di default.</small>
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('billing-profiles.shipping-addresses.delete', ['billing_profile' => $billingProfile->id, 'shipping_address' => $shippingAddress->id]) }}" class="btn btn-link">Elimina</a>
        </form>
    </div>
@endsection
