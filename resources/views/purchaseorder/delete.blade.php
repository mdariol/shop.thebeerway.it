@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina Ordine di Acquisto <em>N. {{ str_pad(strval($purchaseorder->number),6,'0',STR_PAD_LEFT)  }}  - Del: {{  $purchaseorder->date }}  -  a: {{ $purchaseorder->brewery ? $purchaseorder->brewery->name : '' }}</em></h1>
        <form method="POST" action="/purchaseorders/{{ $purchaseorder->id }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Conferma Elimina</button>
            <a href="/purchaseorders" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection