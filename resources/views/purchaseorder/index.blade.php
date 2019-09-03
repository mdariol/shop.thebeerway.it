@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ordini di Acquisto</h1>
        <a class="btn btn-primary mb-2" href="/purchaseorders/create">Nuovo</a>
        @foreach($purchaseorders as $purchaseorder)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">N. {{ str_pad(strval($purchaseorder->number),6,'0',STR_PAD_LEFT)  }}  - Del: {{  $purchaseorder->date }}  -  a: {{ $purchaseorder->brewery ? $purchaseorder->brewery->name : '' }}</p>
                    <div class="float-right">
                        <a href="/purchaseorders/{{ $purchaseorder->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/purchaseorders/{{ $purchaseorder->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection