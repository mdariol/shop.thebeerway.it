@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Utente  {{$user->email}}</h1>

        <form method="POST" action="/users/{{ $user->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Utente</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}">
            </div>


            <horeca-user :user='@json($user)'  > </horeca-user>


            <button class="btn btn-primary">Conferma</button>
        </form>
    </div>
@endsection