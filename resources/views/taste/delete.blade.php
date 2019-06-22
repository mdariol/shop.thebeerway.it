@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $taste->name }}</em></h1>
        <form method="POST" action="/tastes/{{ $taste->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/tastes" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection