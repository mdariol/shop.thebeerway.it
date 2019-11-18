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
            </div>
        @endforeach
    </div>
@endsection