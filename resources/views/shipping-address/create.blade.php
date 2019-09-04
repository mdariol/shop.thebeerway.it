@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuovo</em> Indirizzo di Spedizione</h1>

        <form method="POST" action="{{ route('shipping-addresses.store', ['company' => $company->id]) }}">
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

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('companies.show', ['company' => $company->id]) }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
