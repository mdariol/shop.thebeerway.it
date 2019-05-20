@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $brewery->name }}</em></h1>
        <form method="POST" action="/breweries/{{ $brewery->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/breweries" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection