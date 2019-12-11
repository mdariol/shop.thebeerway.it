@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Promozioni</h1>
        <a class="btn btn-primary mb-2" href="/promotions/create">Nuova</a>

        <div class="card">
            <div class="card-body row">
                <div class="col">
                    Descrizione
                </div>
               <div class="col-sm-3 text-center">
                    priorità
                </div>
                <div class="col-sm-3 text-center">
                    Operazioni
                </div>

            </div>
        </div>
        @foreach($promotions as $promotion)
            <div class="card">
                <div class="card-body row">
                    <div class="col">
                        {{ $promotion->name }} - {{ $promotion->discount }}% - dal {{$promotion->from_date}} al {{$promotion->to_date}}
                    </div>
                   <div class="col-sm-3 text-center">
                        {{$promotion->priority}}
                    </div>
                    <div class="col-sm-3 text-center">
                        <a href="/promotions/{{ $promotion->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/promotions/{{ $promotion->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>

                </div>
                <div>
                    <span class="btn-dark mr-3">Birrifici </span>
                    @foreach($promotion->breweries as $brewery)
                        <a>{{$brewery->name}}</a>
                    @endforeach
                </div>
                <div>
                    <span class="btn-dark mr-3">Birre </span>
                    @foreach($promotion->beers as $beers)
                        <a>{{$beers->name}}</a>
                    @endforeach
                </div>
                <div>
                    <span class="btn-dark mr-3">Utenti </span>
                    @foreach($promotion->users as $user)
                        <a>{{$user->email}}</a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection