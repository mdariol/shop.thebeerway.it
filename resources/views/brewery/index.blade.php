@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Birrifici</h1>
        <a class="btn btn-primary mb-2" href="/breweries/create">Nuovo</a>
        @foreach($breweries as $brewery)
            <div class="card mb-2">
                <div class="card-body">
                    <a class="float-left" href="{{$brewery->website}}" target="_blank">{{ $brewery->name }}</a>

                    <p class="float-left"> - {{ $brewery->isactive }}</p>
                    <div class="float-right">
                        <a href="/breweries/{{ $brewery->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/breweries/{{ $brewery->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection