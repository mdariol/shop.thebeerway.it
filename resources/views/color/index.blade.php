@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Colori</h1>
        <a class="btn btn-primary mb-2" href="/colors/create">Nuovo</a>
        @foreach($colors as $color)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $color->name }}</p>
                    <div class="float-right">
                        <a href="/colors/{{ $color->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/colors/{{ $color->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection