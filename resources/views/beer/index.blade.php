@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Birre</h1>
        <a class="btn btn-primary mb-2" href="/beers/create">Nuova</a>
        @foreach($beers as $beer)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $beer->name }}</p>
                    <div class="float-right">
                        <a href="/beers/{{ $beer->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/beers/{{ $beer->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection