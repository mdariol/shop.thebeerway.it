@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="text-primary d-flex flex-row" >
            <div class="p-2 col-7" >Data - Numero - Utente - Azienda</div>
            <div class="p-2 col-3" >Totale imponibile</div>
            <div class="p-2 col-2">Stato</div>
        </div>

        @foreach($orders as $order)
            <div class="text-primary d-flex flex-row" >
                <div class="p-2 col-7">{{ $order->date }} - {{ $order->number }} - {{ $order->user->name }} - {{ $order->company->business_name }}</div>
                <div class="p-2 col-3">{{ $order->total_amount }}</div>
                <div class="p-2 col-2">{{ $order->status }}</div>
            </div>
            <div class="d-none d-es-table-cell">
                {{ $order->company->business_name }}
            </div>

            <hr class="w-100 mb-1 mt-1">
        @endforeach
    </div>
@endsection
