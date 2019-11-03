@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profili di Fatturazione</h1>

        <p>L'elenco dei tuoi profili di fatturazione.</p>

        <a href="{{ route('billing-profiles.create') }}" class="btn btn-primary mb-5">Aggiungi</a>

        @empty($billingProfiles)
            <p class="text-muted">Non hai ancora aggiunto alcuna società...</p>
        @endempty

        @foreach($billingProfiles as $billingProfile)
            <article class="d-md-flex border-bottom mb-3">
                <div class="flex-grow-1">
                    <h4 class="text-truncate">
                        <a href="{{ route('billing-profiles.show', ['id' => $billingProfile->id]) }}">{{ $billingProfile->name }}</a>
                        <small class="text-muted ml-2">IT-{{ $billingProfile->vat_number }}</small>
                    </h4>
                    <p>{{ $billingProfile->address }}</p>
                </div>
                <div class="align-self-center mb-3">
                    <a href="{{ route('billing-profiles.edit', ['id' => $billingProfile->id]) }}" class="btn btn-primary">Modifica</a>
                    <a href="{{ route('billing-profiles.delete', ['billing-profile' => $billingProfile->id]) }}" class="btn btn-link">Elimina</a>
                </div>
            </article>
        @endforeach
    </div>
@endsection

