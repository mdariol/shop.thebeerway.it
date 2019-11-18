@extends('layouts.app')

@section('content')



    <div class="container">


        <h1>Modifica Promozione <em>{{ $promotion->name }} - {{ $promotion->from_date }} - {{ $promotion->to_date }} </em> </h1>

        <form method="POST" action="/promotions/{{ $promotion->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" value="{{ $promotion->name }}"></text>
            </div>

            <div class="form-group">
                <label for="discount">Sconto</label>
                <input type="number" name="discount" id="discount" min="0" max="100" step=".50" value="{{ $promotion->discount }}">
            </div>

            <div class="form-group">
                <label for="from_date">dalla data</label>
                <input type="date" name="from_date" id="from_date" value="{{ $promotion->from_date }}">
            </div>

            <div class="form-group">
                <label for="to_date">alla data</label>
                <input type="date" name="to_date" id="to_date" value="{{ $promotion->to_date }}">
            </div>

            <div class="form-group">
                <label for="priority">priorità</label>
                <input type="number" name="priority" id="priority" value="{{ $promotion->priority }}">
            </div>


            <button class="btn btn-primary">Aggiorna</button>
        </form>
    </div>

@endsection