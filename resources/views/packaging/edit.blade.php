@extends('layouts.app')

@section('content')



    <div class="container">
        <h1>Modifica Packaging <em>{{ $packaging->name }}</em> </h1>


        <form method="POST" action="/packagings/{{ $packaging->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="type">Tipo</label>
                <select class="form-control" name="type" id="type">
                    <option label=" ">-- Seleziona un'opzione --</option>
                    @foreach(\App\Packaging::TYPE as $type)
                        <option {{ $packaging->type == $type ? 'selected' : '' }} value="{{ $type }}">
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantità</label>
                <input type="number" name="quantity" id="quantity" value="{{ $packaging->quantity }}">
            </div>
            <div class="form-group">
                <label for="capacity">Capacità Unitaria Lt</label>
                <input type="number" name="capacity" step=".01" id="capacity" value="{{ $packaging->capacity/100 }}">
            </div>

            <button class="btn btn-primary">Aggiorna</button>
        </form>
    </div>

@endsection