@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Società</h1>

        <p>L'elenco delle tue società.</p>

        <a href="{{ route('companies.create') }}" class="btn btn-primary mb-5">Aggiungi</a>

        @if( ! $companies->count())
            <p class="text-muted">Non hai ancora aggiunto alcuna società...</p>
        @endif

        @foreach($companies as $company)
            <article class="d-md-flex border-bottom mb-3">
                <div class="flex-grow-1">
                    <h4 class="text-truncate">
                        <a href="{{ route('companies.show', ['id' => $company->id]) }}">{{ $company->business_name }}</a>
                        <small class="text-muted ml-2">IT-{{ $company->vat_number }}</small>
                    </h4>
                    <p>{{ $company->address }}</p>
                </div>
                <div class="align-self-center">
                    <a href="{{ route('companies.edit', ['id' => $company->id]) }}" class="btn btn-primary mb-3">Modifica</a>
                </div>
            </article>
        @endforeach
    </div>
@endsection

