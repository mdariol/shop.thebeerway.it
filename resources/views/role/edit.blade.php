@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Ruolo</h1>

        <form method="POST" action="/roles/{{ $role->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Ruolo</label>
                <input type="text" name="name" id="name" value="{{ $role->name }}">
            </div>

            <button class="btn btn-primary">Conferma</button>
        </form>
    </div>
@endsection