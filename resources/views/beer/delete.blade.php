@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $beer->name }}</em></h1>
        <form method="POST" action="/beers/{{ $beer->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Delete</button>
            <a href="/beers" class="btn btn-link">Cancel</a>
        </form>
    </div>
@endsection