@extends('layouts.app')


@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center" >
        <img src="Logo - The BeerWay.png" alt="The BeerWay Logo" height="70%" width="70%" class="mb-4">
        <h3 class="mb-4">Disponibilità</h3>
        <a class="btn btn-dark mb-2 btn-lg" href="/beers?packaging=fusti">Fusti</a>
        <a class="btn btn-warning mb-2 btn-lg" href="/beers?packaging=bottiglie">Bottiglie</a>
    </div>
@endsection