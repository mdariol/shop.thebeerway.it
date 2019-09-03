@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuovo</em> Indirizzo di Spedizione</h1>

        <form method="POST" action="{{ route('shipping-addresses.store', ['company' => $company->id]) }}">
            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Mario Rossi" required>
            </div>

            <place></place>

            <div class="form-group">
                <label for="phone">Telefono</label>
                <input type="tel" name="phone" class="form-control" id="phone" required pattern="^[0-9 ]*$">
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('companies.show', ['company' => $company->id]) }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
