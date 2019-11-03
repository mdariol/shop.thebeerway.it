@extends('layouts.app')

@section('content')
    <div class="container col-xl-4 col-lg-6 col-md-8" id="welcome">
        <div class="clearfix">
            <h1 class="display-4">Benvenuto,<br> {{ $user->name }}!</h1>
            <p class="lead text-muted">Tre sempici passaggi per iniziare al meglio.</p>
            <hr class="mb-5 mt-2 w-25 float-left">
        </div>

        <h3>Verifica indirizzo e-mail</h3>
        <p>Abbiamo appena inviato un link di verifica al tuo indirizzo e-mail. Verificando l'indirizzo e-mail sarai in grado di <strong>effettuare ordini</strong> sul nostro portale.</p>

        <h3>Profilo di Fatturazione</h3>
        <p><a href="{{ route('billing-profiles.create') }}">Crea un Profilo di Fatturazione.</a> Grazie al profilo di fatturazione sarai in grado di visualizzare i <strong>prezzi Ho.Re.Ca. e le disponibilità</strong>.</p>

        <h3>Filtra le birre!</h3>
        <p>No, non è quello che pensi... <a href="{{ route('beers.index') }}">Visualizzando le nostre birre</a>, noterai dei filtri in alto. Ti permetteranno di <strong>affinare la ricerca</strong> e trovare la tua birra preferita in un lampo!</p>
    </div>
@endsection
