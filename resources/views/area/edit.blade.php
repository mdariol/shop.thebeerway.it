@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Area</h1>

        <form method="POST" action="/areas/{{ $area->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Area</label>
                <input type="text" name="name" id="name" value="{{ $area->name }}">
            </div>

            <button class="btn btn-primary">Conferma</button>
        </form>
    </div>
@endsection