@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $user->name }}</em></h1>
        <form method="POST" action="/users/{{ $user->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/users" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection