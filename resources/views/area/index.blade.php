@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Aree</h1>
        <a class="btn btn-primary mb-2" href="/areas/create">Nuova</a>
        @foreach($areas as $area)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $area->name }}</p>
                    <div class="float-right">
                        <a href="/areas/{{ $area->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/areas/{{ $area->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection