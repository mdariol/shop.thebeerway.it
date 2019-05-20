@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Packagings</h1>
        <a class="btn btn-primary mb-2" href="/packagings/create">Nuovo</a>

        <div class="card">
            <div class="card-body row">
                <div class="col">
                    Package
                </div>
                <div class="col text-center">
                    Quantità
                </div>
                <div class="col text-center">
                    Capacità unitaria Lt
                </div>
                <div class="col text-center">
                    Operazioni
                </div>
            </div>
        </div>
        @foreach($packagings as $packaging)
            <div class="card">
                <div class="card-body row">
                    <div class="col">
                        {{ $packaging->name }}
                    </div>
                    <div class="col text-center">
                        {{ $packaging->quantity }}
                    </div>
                    <div class="col text-center">
                        {{$packaging->capacity/100}}
                    </div>

                    <div class="col text-center">
                        <a href="/packagings/{{ $packaging->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/packagings/{{ $packaging->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection