@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuovo</em> Ordine</h1>
        <p class="mb-4">Stai creando un ordine per <strong>{{ $user->email }}</strong>.</p>

        <form method="POST" action="{{ route('admin.orders.store') }}">
            @csrf

            <billing-shipping :billing-profiles='@json($billingProfiles)'
                              :errors='@json($errors->get('*'))'></billing-shipping>

            <div class="form-group">
                <label for="delivery-note">Note</label>
                <textarea class="form-control" name="deliverynote" id="delivery-note" cols="30" rows="5"></textarea>
                <small class="form-text text-muted">Aggiungi delle note per la consegna.</small>
            </div>

            <hr class="my-4">

            <h4 class="mb-3">Carrello</h4>
            <line-create :errors='@json($errors->get('*'))'></line-create>

            <button class="btn btn-primary" name="state" value="sent">Salva</button>
        </form>
    </div>
@endsection
