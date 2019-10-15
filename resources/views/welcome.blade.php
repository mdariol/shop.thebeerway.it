@extends('layouts.app')

@section('content')
    <!--
    <div class="d-flex flex-column justify-content-center align-items-center" >
        <img src="Logo - The BeerWay.png" alt="The BeerWay Logo" height="70%" width="70%" class="mb-4">
        <h3 class="mb-4">Disponibilità</h3>
        <a class="btn btn-dark mb-2 btn-lg" href="/beers?packaging=fusti&stock=on">Fusti</a>
        <a class="btn btn-warning mb-2 btn-lg" href="/beers?packaging=bottiglie&stock=on">Bottiglie</a>
    </div>
    -->
    <div class="container col-xl-4 col-lg-6 col-md-8" id="welcome">
        <div class="clearfix">
            <h1 class="display-4">Benvenuto,<br> {{ $user->name }}!</h1>
            <p class="lead text-muted">Tre sempici passaggi per iniziare al meglio.</p>
            <hr class="mb-5 mt-2 w-25 float-left">
        </div>

        <h3>Verifica indirizzo e-mail</h3>
        <p>Abbiamo appena inviato un link di verifica al tuo indirizzo e-mail. Verificando l'indirizzo e-mail sarai in grado di <strong>effettuare ordini</strong> sul nostro portale.</p>

        <h3>Utente Ho.Re.Ca.</h3>
        <p>Sei un utente Ho.Re.Ca.? <a href="{{ route('companies.create') }}">Registra la tua società.</a> Registrando la tua società sarai in grado di visualizzare i <strong>prezzi Ho.Re.Ca. e le disponibilità</strong>.</p>

        <h3>Filtra le birre!</h3>
        <p>No, non è quello che pensi... <a href="{{ route('beers.index') }}">Visualizzando le nostre birre</a>, noterai dei filtri in alto. Ti permetteranno di <strong>affinare la ricerca</strong> e trovare la tua birra preferita in un lampo!</p>
    </div>
@endsection
