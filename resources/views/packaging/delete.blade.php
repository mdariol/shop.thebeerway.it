@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Delete <em>{{ $packaging->name }}</em></h1>
        <p>This action cannot be undone.</p>
        <form method="POST" action="/packagings/{{ $packaging->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Delete</button>
            <a href="/packagings" class="btn btn-link">Cancel</a>
        </form>
    </div>
@endsection