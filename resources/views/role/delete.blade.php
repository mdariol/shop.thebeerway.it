@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $role->name }}</em></h1>
        <form method="POST" action="/roles/{{ $role->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/roles" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection