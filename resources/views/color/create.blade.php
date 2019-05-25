@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Colore</h1>

        <form method="POST" action="/colors">
            @csrf

            <div class="form-group">
                <label for="name">Colore</label>
                <input type="text" name="name" id="name">
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection