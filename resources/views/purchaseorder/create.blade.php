@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Ordine di Acquisto</h1>

        <form method="POST" action="/purchaseorders">
            @csrf

            <div class="form-group">
                <label for="number">Numero</label>
                <input type="text" name="number" id="number">
            </div>
            <div class="form-group">
                <label for="date">Data</label>
                <input type="date" name="date" id="date">
            </div>
            <div class="form-group">
                <label for="brewery-id">Birrificio</label>
                <select class="form-control" name="brewery_id" id="brewery-id">
                    <option value=" ">-- Seleziona un Birrificio --</option>
                    @foreach($breweries as $brewery)
                        <option value="{{$brewery->id}}"> {{$brewery->name}} </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection