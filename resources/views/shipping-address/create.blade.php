@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuovo</em> Indirizzo di Spedizione</h1>

        <form method="POST" action="{{ route('billing-profiles.shipping-addresses.store', ['billing-profile' => $billingProfile->id]) }}">
            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" placeholder="Mario Rossi" required
                       class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <place></place>

            <div class="form-group">
                <label for="phone">Telefono <span class="text-muted">(Opzionale)</span></label>
                <input type="tel" name="phone" id="phone" pattern="^\+?[0-9 ]*"
                       class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                @else
                    <small class="text-muted">Verrà usato per eventuali comunicazioni sulla consegna.</small>
                @endif
            </div>

            <div class="form-group custom-control custom-switch">
                <input type="checkbox" name="is_default" id="is-default" class="custom-control-input">
                <label class="custom-control-label" for="is-default">Indirizzo predefinito</label>
                <small class="form-text text-muted">Verrà utilizzato come indirizzo di default.</small>
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('billing-profiles.show', ['billing-profile' => $billingProfile->id]) }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
