@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Birrificio</h1>

        <form method="POST" action="/breweries/{{ $brewery->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Birrificio</label>
                <input type="text" name="name" id="name" value="{{ $brewery->name }}">
            </div>

            <button class="btn btn-primary">Aggiorna</button>
        </form>
    </div>
@endsection