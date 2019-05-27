@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $color->name }}</em></h1>
        <form method="POST" action="/areas/{{ $color->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/colors" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection