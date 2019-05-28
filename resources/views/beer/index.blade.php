@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Birre</h1>
        <a class="btn btn-primary mb-2" href="/beers/create">Nuova</a>

        <!--
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
        -->

        @foreach($beers as $beer)
            <div class="row align-items-center">
                <div class="col-sm">
                    <h3>{{ $beer->name }} <small class="text-muted">// {{ $beer->brewery->name }}</small></h3>
                    <p class="text-muted">
                        {{ $beer->style ? $beer->style->name : '' }}
                        {{ $beer->color ? $beer->color->name : '' }} da {{ $beer->abv }}%
                    </p>
                </div>
                <div class="col-sm-auto">
                    <a href="/beers/{{ $beer->id }}/edit" class="btn btn-primary">Modifica</a>
                    <a href="/beers/{{ $beer->id }}/delete" class="btn btn-danger">Elimina</a>
                </div>
                <hr class="w-100">
            </div>
        @endforeach
    </div>
@endsection