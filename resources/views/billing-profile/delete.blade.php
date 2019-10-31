@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $billingProfile->name }}</em></h1>
        <form method="POST" action="{{ route('billing-profiles.destroy', ['billing_profile' => $billingProfile->id]) }}">
            @csrf
            @method('DELETE')

            <p>Sei sicuro di voler eliminare {{ $billingProfile->name }}? Questa azione è <em>irreversibile</em>.</p>
            <button type="submit" class="btn btn-primary">Elimina</button>
            <a href="{{ route('billing-profiles.index') }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
