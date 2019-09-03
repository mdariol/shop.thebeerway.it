@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Ordine</h1>

        <form method="POST" action="/orders">
            @csrf

            <div class="form-group">
                <label for="deliverynote">Nota sulla consegna</label>
                <input type="text" name="deliverynote" id="deliverynote">
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