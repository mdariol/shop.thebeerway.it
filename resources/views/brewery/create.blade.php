@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Birrificio</h1>

        <form method="POST" action="/breweries">
            @csrf

            <div class="form-group">
                <label for="name">Birrificio</label>
                <input type="text" name="name" id="name">
            </div>

            <div class="form-group">
                <label for="name">Sito Web</label>
                <input type="text" name="website" id="website">
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection