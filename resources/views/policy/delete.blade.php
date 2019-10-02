@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $policy->name }} - {{ $policy->from_date }}</em></h1>
        <form method="POST" action="/policies/{{ $policy->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/policies" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection