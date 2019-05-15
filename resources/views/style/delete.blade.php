@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Delete <em>{{ $style->name }}</em></h1>
        <p>This action cannot be undone.</p>
        <form method="POST" action="/styles/{{ $style->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Delete</button>
            <a href="/styles" class="btn btn-link">Cancel</a>
        </form>
    </div>
@endsection