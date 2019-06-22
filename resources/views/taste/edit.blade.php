@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Gusto Prevalente</h1>

        <form method="POST" action="/tastes/{{ $taste->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Gusto Prevalente</label>
                <input type="text" name="name" id="name" value="{{ $taste->name }}">
            </div>

            <button class="btn btn-primary">Conferma</button>
        </form>
    </div>
@endsection