@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $style->name }}</em></h1>
        <form method="POST" action="/styles/{{ $style->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/styles" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection