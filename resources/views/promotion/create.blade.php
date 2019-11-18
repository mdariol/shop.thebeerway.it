@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuova Promozione</h1>

        <form method="POST" action="/promotions">
            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" ></input>
            </div>

            <div class="form-group">
                <label for="discount">Sconto</label>
                <input type="number" name="discount" id="discount" min="0" max="100" step="0.50">
            </div>
            <div class="form-group">
                <label for="from_date">dalla data</label>
                <input type="date" name="from_date" id="from_date">
            </div>
            <div class="form-group">
                <label for="to_date">alla data</label>
                <input type="date" name="to_date" id="to_date">
            </div>
            <div class="form-group">
                <label for="priority">Priorità</label>
                <input type="number" name="priority" id="priority" value="0">
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection