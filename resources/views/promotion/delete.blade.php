@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $promotion->name }} - {{ $promotion->from_date }} - {{ $promotion->to_date }}</em></h1>
        <form method="POST" action="/promotions/{{ $promotion->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/promotions" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection