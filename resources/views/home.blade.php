@extends('layouts.app')

@section('content')
<div class="container">
    <!--
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>Sei entrato nel nostro portale!</p>
                    <p>Clicca sull'immagine del fusto per consultare i fusti</p>
                    <p>oppure sull'immagine della bottiglia per consultare le bottiglie</p>
                    <p>Dopo la selezione potrai filtrare i birrifici, gli stili e altre opzioni cliccando su "Filtri"</p>
                    <p>Potrai anche selezionare l'intero catalogo togliento l'indicatore "Solo Disponibili"</p>
                    <p>Ricordati di cliccare "Applica Filtri" per rendere attive le tue scelte</p>
                </div>
            </div>
        </div>
    </div>
    -->

    <div class="d-flex flex-column justify-content-center align-items-center" >
        <img src="Logo - The BeerWay.png" alt="The BeerWay Logo" height="70%" width="70%" class="mb-4">
        <h3 class="mb-4">Disponibilità</h3>
        <a class="btn btn-dark mb-2 btn-lg" href="/beers?packaging=fusti&stock=on">Fusti</a>
        <a class="btn btn-warning mb-2 btn-lg" href="/beers?packaging=bottiglie&stock=on">Bottiglie</a>


        <div id="carousel" class="carousel slide d-flex flex-column justify-content-center align-items-center" data-ride="carousel" >
            <div class="carousel-inner">

                @foreach($breweries as $brewery)
                    @if ($loop->first)
                        <div class="carousel-item active ">
                    @else
                        <div class="carousel-item">
                    @endif
                    <h2 class="text-center text-black-50 mt-3 mb-3">
                        Birrificio {{$brewery->name}}
                    </h2>
                    @if ($brewery->logo)
                        <img class="d-block" src="{{ asset('storage/'.$brewery->logo) }}"  style="height: 200px; ">
                    @endif
                    </div>
                @endforeach

            </div>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Precedente</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Successivo</span>
            </a>
        </div>







    </div>


</div>
@endsection
