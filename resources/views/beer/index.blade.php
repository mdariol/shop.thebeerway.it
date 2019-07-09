@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-capitalize">{{ request()->packaging }}  {{ request()->has('stock') ? ' (Disponibili)' : '(Catalogo)' }}</h3>

        @hasrole('Admin')
            <a class="btn btn-primary mb-2" href="/beers/create?packaging={{ request()->packaging }} ">Nuova</a>
            <a class="btn btn-warning mb-2" href="/stocksync">Sincronizza Stock</a>

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

@if( (auth()->user() && auth()->user()->hasrole('Admin')) or ($beer->brewery->isactive and $beer->isactive))

            <div class="row align-items-center mb-0 mt-0">
                <div class="col-sm mb-0 mt-0">
                    <h5 class="text-primary" data-toggle="collapse" href={{ "#beer".$beer->id }} aria-expanded="false" aria-controls={{ "beer".$beer->id }}>{{ $beer->name }} <small class="text-secondary"> - {{ $beer->brewery->name }}
                            @if(auth()->user())
                            [{{$beer->stock}}]
                            @endif

                            </small></h5>
                        <h6 class="text-body">{{ $beer->style ? $beer->style->name.', ' : '' }}
                            {{ $beer->color ? $beer->color->name.', ' : ''}}
                            {{ $beer->taste ? $beer->taste->name.', ' : ''}}
                            {{ $beer->abv ? 'da '.$beer->abv.'%, ' : ''}}
                            {{ $beer->packaging ? $beer->packaging->name : '' }}.
                        </h6>


                    </div>



                    @hasanyrole('Publican|Admin|Distributor')
                        <div class="col-sm-auto">
                            <h6 class="text-body">&euro; {{ $beer->price  ? $beer->price->distribution : 'n/d'}} {{ ($beer->price && $beer->packaging->type=='fusti' ) ? '- €/lt '.$beer->price->distributionLiter : ' '}}
                                {{ ($beer->price && $beer->packaging->type=='bottiglie' ) ? '- €/bt '.$beer->price->distribution_unit : ' '}} (+Iva)</h6>
                        </div>
                    @endhasanyrole

                    <div class="col-sm-auto">
                    @hasrole('Admin')
                            <a href="/beers/{{ $beer->id }}/duplicate?packaging={{ request()->packaging }} " class="btn-primary"> Duplica </a>
                            <a href="/beers/{{ $beer->id }}/edit?packaging={{ request()->packaging }} " class="btn-primary ml-2"> Modifica </a>
                            <a href="/beers/{{ $beer->id }}/delete?packaging={{ request()->packaging }} " class="btn-danger ml-2 mr-2"> Elimina </a>
                    @endhasrole
                        <a class="text-primary" data-toggle="collapse" href={{ "#beer".$beer->id }}  aria-expanded="false" aria-controls={{ "beer".$beer->id }} > Espandi </a>

                    </div>

                    <div class="card collapse w-100 " id={{ "beer".$beer->id }}>
                        <div class="card card-body pb-1 pt-1 pl-3 pr-3">
                            {{ $beer->description }}
                        </div>
                    </div>

                    <hr class="w-100 mb-1 mt-1">
                </div>
    @endif
            @endforeach
        </div>
    @endsection