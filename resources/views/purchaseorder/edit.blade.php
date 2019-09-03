@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica </em> Ordine di Acquisto Numero {{ $purchaseorder->number }}</h1>



        <form method="POST" action="/purchaseorders/{{ $purchaseorder->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="number">Numero</label>
                <input type="text" name="number" id="number" value="{{ $purchaseorder->number }}">
            </div>

            <div class="form-group">
                <label for="date">Data</label>
                <input type="date" name="date" id="date" value="{{ $purchaseorder->date }}">
            </div>
            <div class="form-group">
                <label for="brewery_id">Birrificio</label>
                <select class="form-control" name="brewery_id" id="brewery_id">
                    <option label=" ">-- Seleziona un Birrificio --</option>
                    @foreach($breweries as $brewery)
                        <option {{ $purchaseorder->brewery == $brewery ? 'selected' : '' }} value="{{ $brewery->id }}">
                            {{ $brewery->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Aggiorna</button>
        </form>
    </div>
@endsection