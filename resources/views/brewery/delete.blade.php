@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Delete <em>{{ $brewery->name }}</em></h1>
        <p>This action cannot be undone.</p>
        <form method="POST" action="/breweries/{{ $brewery->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Delete</button>
            <a href="/breweries" class="btn btn-link">Cancel</a>
        </form>
    </div>
@endsection