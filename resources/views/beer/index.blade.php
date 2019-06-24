@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-capitalize">{{ request()->packaging }}</h3>

        @hasrole('Admin')
            <a class="btn btn-primary mb-2" href="/beers/create">Nuova</a>
        @endhasrole

        <div class="card mb-2 mt-2 ">
            <div class="card-header">
                <h6 small class="mb-0" data-toggle="collapse" data-target="#filter">Filtri</h6>
            </div>
            <div class="card-body collapse" id="filter">
                <form method="GET" action="/beers">

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input mb-2" name="stock" id="stock"
                                {{ request()->has('stock') ? 'checked' : '' }}>
                        <label for="stock" class="form-check-label mb-2" >Solo Disponibili</label>
                    </div>

                    <autocomplete :options='@json($breweries)' name='brewery' label='Birrificio'></autocomplete>
                    <autocomplete :options='@json($styles)' name='style' label='Stile'></autocomplete>
                    <autocomplete :options='@json($colors)' name='color' label='Colore'></autocomplete>
                    <autocomplete :options='@json($tastes)' name='taste' label='Gusto Prevalente'></autocomplete>


                    <div class="form-group">
                        <label for="name">Birra</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ request()->name }}">
                    </div>

                    <div class="form-group" hidden>
                        <label for="name">Packaging</label>
                        <input type="text" class="form-control" name="packaging" id="packaging" value="{{ request()->packaging }}">
                    </div>



                    <button class="btn btn-primary">Applica Filtri</button>
                    <a href="/beers?packaging={{ request()->packaging }}" class="btn btn-link">Reset Filtri</a>

                </form>
            </div>
        </div>

        @foreach($beers as $beer)
            <div class="row align-items-center mb-0 mt-0">
                <div class="col-sm mb-0 mt-0">
                    <h5 class="text-primary" data-toggle="collapse" href={{ "#beer".$beer->id }} aria-expanded="false" aria-controls={{ "beer".$beer->id }}>{{ $beer->name }} <small class="text-secondary"> - {{ $beer->brewery->name }}</small></h5>
                    <h6 class="text-body">{{ $beer->style ? $beer->style->name.', ' : '' }}
                        {{ $beer->color ? $beer->color->name.', ' : ''}}
                        {{ $beer->taste ? $beer->taste->name.', ' : ''}}
                        {{ $beer->abv ? 'da '.$beer->abv.'%, ' : ''}}
                        {{ $beer->packaging ? $beer->packaging->name : '' }}.
                    </h6>
                    <div class="collapse" id={{ "beer".$beer->id }}>
                        <div class="card card-body p-1">
                            {{ $beer->description }}
                        </div>
                    </div>


                </div>



                @hasanyrole('Publican|Admin')
                    <div class="col-sm-auto">
                        <h6 class="text-body">&euro; {{ $beer->price  ? $beer->price->distribution : 'n/d'}} {{ ($beer->price && $beer->packaging->type=='fusti' ) ? '- €/lt '.$beer->price->distributionLiter : ' '}}
                            {{ ($beer->price && $beer->packaging->type=='bottiglie' ) ? '- €/bt '.$beer->price->distribution_unit : ' '}}</h6>
                    </div>
                @endhasanyrole

                @hasrole('Admin')
                    <div class="col-sm-auto">
                        <a href="/beers/{{ $beer->id }}/edit" class="btn-primary">Modifica</a>
                        <a href="/beers/{{ $beer->id }}/delete" class="btn-danger">Elimina</a>
                    </div>
                @endhasrole
                <hr class="w-100 mb-1 mt-1">
            </div>
        @endforeach
    </div>
@endsection