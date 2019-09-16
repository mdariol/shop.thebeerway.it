@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $company->business_name }}</em></h1>
        <form method="POST" action="/companies/{{ $company->id }}">
            @csrf
            @method('DELETE')

            <p>Sei sicuro di voler eliminare {{ $company->business_name }}? Questa azione è <em>irreversibile</em>.</p>
            <button type="submit" class="btn btn-primary">Elimina</button>
            <a href="{{ route('companies.index' }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
