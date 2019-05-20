@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Packaging</h1>

        <form method="POST" action="/packagings">
            @csrf

            <div class="form-group">
                <label for="type">Tipo</label>
                <select class="form-control" name="type" id="type">
                    <option label=" ">-- Seleziona un'opzione --</option>
                    @foreach(\App\Packaging::TYPE as $type)
                        <option value="{{ $type }}">
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantità</label>
                <input type="number" name="quantity" id="quantity" >
            </div>
            <div class="form-group">
                <label for="capacity">Capacità Unitaria Lt.</label>
                <input type="number" step=".01" name="capacity" id="capacity">
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection