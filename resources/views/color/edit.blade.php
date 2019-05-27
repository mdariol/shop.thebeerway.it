@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Colore</h1>

        <form method="POST" action="/colors/{{ $color->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Colore</label>
                <input type="text" name="name" id="name" value="{{ $color->name }}">
            </div>

            <button class="btn btn-primary">Conferma</button>
        </form>
    </div>
@endsection