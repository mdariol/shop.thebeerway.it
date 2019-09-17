@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $user->name }}</em></h1>
        <form method="POST" action="/users/{{ $user->id }}">
            @csrf
            @method('DELETE')

            <p>Sei sicuro di voler eliminare {{ $user->name }}? Questa azione è <em>irreversibile</em>.</p>
            <button type="submit" class="btn btn-primary">Elimina</button>
            <a href="{{ route('users.show', ['user' => $user->id]) }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
