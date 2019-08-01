@extends('layouts.app')

@section('content')
<div class="container">
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
</div>
@endsection
