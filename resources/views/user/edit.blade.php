@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Utente</h1>

        <form method="POST" action="/users/{{ $user->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Utente</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}">
            </div>

            @if($user->ishoreca)
                <label for="horecaname">Nome Ho.Re.Ca.</label>
                <input type="text" name="horecaname" id="horecaname" value="{{ $user->horecaname }}">
                @hasrole('Admin')
                    <label for="vatnumber">Partita Iva</label>
                    <input type="text" name="vatnumber" id="vatnumber" value="{{ $user->vatnumber}}">
                @endhasrole
            @endif

            <button class="btn btn-primary">Conferma</button>
        </form>
    </div>
@endsection