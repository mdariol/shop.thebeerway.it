@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Birre</h1>
        <a class="btn btn-primary mb-2" href="/beers/create">Nuova</a>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0" data-toggle="collapse" data-target="#filter">Filtri</h5>
            </div>
            <div class="card-body collapse" id="filter">
                <form method="GET" action="/beers">

                    <autocomplete :options='@json($breweries)' name='brewery' label='Birrificio'></autocomplete>
                    <autocomplete :options='@json($styles)' name='style' label='Stile'></autocomplete>
                    <autocomplete :options='@json($colors)' name='color' label='Colore'></autocomplete>


                    <div class="form-group">
                        <label for="name">Birra</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ request()->name }}">
                    </div>

                    <button class="btn btn-primary">Applica Filtri</button>
                    <a href="/beers" class="btn btn-link">Reset Filtri</a>

                </form>
            </div>
        </div>

        @foreach($beers as $beer)
            <div class="row align-items-center">
                <div class="col-sm">
                    <h3>{{ $beer->name }} <small class="text-muted">// {{ $beer->brewery->name }}</small></h3>
                    <p class="text-muted">{{ $beer->style->name }}, {{ $beer->color->name }} da {{ $beer->abv }}%.
                        {{ $beer->packaging->name }}.</p>
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