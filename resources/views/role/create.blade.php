@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Ruolo</h1>

        <form method="POST" action="/roles">
            @csrf

            <div class="form-group">
                <label for="name">Ruolo</label>
                <input type="text" name="name" id="name">
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection