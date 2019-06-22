@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Gusto Prevalente</h1>

        <form method="POST" action="/tastes">
            @csrf

            <div class="form-group">
                <label for="name">Gusto Prevalente</label>
                <input type="text" name="name" id="name">
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection