@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-capitalize">{{ request()->packaging }}  {{ request()->has('stock') ? ' (Disponibili)' : '(Catalogo)' }}</h3>

        @hasrole('Admin')
            <a href="{{str_replace('?', '/create?' , request()->getRequestUri() )}}" >
                <img src="/Nuovo-TheBeerWay.png" alt="Carrello" height="30px" class="pr-3">
            </a>

            <a class="btn btn-warning mb-2" href="/stocksync">Sincronizza Stock</a>

        @endhasrole

        <div class="card m-0 p-0 border-0">
            <div class="card-header m-0 pl-0 pr-0 pt-0 pb-2 border-0">
                <h1  class="btn btn-dark btn-lg m-0 p-0 w-100 border-0" data-toggle="collapse" role="button" data-target="#filter">
                    <img src="/Imbuto-TheBeerWay.png" alt="Carrello" height="20px" >
                    Filtri
                </h1>
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


            <div class="row align-items-center mb-0 mt-0" >
                <div class="col-sm mb-0 mt-0" data-toggle="collapse" href={{ "#beer".$beer->id }} aria-expanded="false" aria-controls={{ "beer".$beer->id }} >

                    <h5 class="text-primary" >
                        @if ($beer->image)
                            <div class="d-inline-block text-center" style="height: 40px; width: 40px">
                                <img src="{{ asset('storage/'.$beer->image) }}" style="height: 40px; ">
                            </div>
                        @endif


                        {{ $beer->name }}<small class="text-secondary"> - {{ $beer->brewery ? $beer->brewery->name : ''}}
                            @if(auth()->user())
                            [{{$beer->stock - $beer->requested_stock}}]
                            @endif

                            </small></h5>
                        <h6 class="text-body" >
                            {{ $beer->style ? $beer->style->name.', ' : '' }}
                            {{ $beer->color ? $beer->color->name.', ' : ''}}
                            {{ $beer->taste ? $beer->taste->name.', ' : ''}}
                            {{ $beer->abv ? 'da '.$beer->abv.'%, ' : ''}}
                            {{ $beer->packaging ? $beer->packaging->name : '' }}.
                            @hasanyrole('Publican|Admin|Distributor')

                            @else
                                <div class="col-sm-auto " >
                                    <a class="text-primary" data-toggle="collapse" href={{ "#beer".$beer->id }}  aria-expanded="false" aria-controls={{ "beer".$beer->id }} >
                                        <img src="/Espandi-TheBeerWay.png" alt="Espandi" height="20px" >
                                    </a>
                                </div>
                            @endhasanyrole
                        </h6>


                    </div>

                    @hasanyrole('Publican|Admin|Distributor')
                        <div class="col-sm-auto " >
                            <h6 class="text-body mb-0" >&euro; {{ $beer->price  ? $beer->price->distribution : 'n/d'}} {{ ($beer->price && $beer->packaging->type=='fusti' ) ? '- €/lt '.$beer->price->distributionLiter : ' '}}
                                {{ ($beer->price && $beer->packaging->type=='bottiglie' ) ? '- €/bt '.$beer->price->distribution_unit : ' '}} (+Iva)
                                <a  href="{{str_replace('?', '/'.$beer->id.'/addtocart?' , request()->getRequestUri() )}}" >
                                    <img src="/Carrello-TheBeerWay.png" alt="Carrello" height="30px" class="pl-3">
                                </a>
                                <a class="text-primary" data-toggle="collapse" href={{ "#beer".$beer->id }}  aria-expanded="false" aria-controls={{ "beer".$beer->id }} >
                                    <img src="/Espandi-TheBeerWay.png" alt="Espandi" height="30px" class="pl-3">
                                </a>
                            </h6>
                        </div>
                    @endhasanyrole

                    <div class="card collapse w-100 pl-3 pr-3 pt-1 pb-1 border-0" id={{ "beer".$beer->id }}>
                        <div class="card card-body  m-0 p-0 border-0">
                            {{ $beer->description }}
                        </div>
                    </div>

                    <hr class="w-100 mb-1 mt-1">



                    @hasrole('Admin')
                    <div class="col-sm-auto">
                            <a  href="{{str_replace('?', '/'.$beer->id.'/duplicate?' , request()->getRequestUri() )}}" >
                                <img src="/Duplica-TheBeerWay.png" alt="Duplica" height="30px">
                            </a>
                            <a  href="{{str_replace('?', '/'.$beer->id.'/edit?' , request()->getRequestUri() )}}" >
                                <img src="/Modifica-TheBeerWay.png" alt="Modifica" height="30px" class="pl-3">
                            </a>
                            <a  href="{{str_replace('?', '/'.$beer->id.'/delete?' , request()->getRequestUri() )}}" >
                                <img src="/Elimina-TheBeerWay.png" alt="Elimina" height="30px" class="pl-3">
                            </a>
                    </div>
                    <hr class="w-100 mb-1 mt-1">
                    @endhasrole

                </div>
            @endforeach
        </div>
    @endsection