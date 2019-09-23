@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="text-white d-flex flex-row bg-dark" >
            <div class="p-2 col-sm-9 text-left" >Ordine</div>
            <div class="p-2 col-sm-1 text-right">Stato</div>
            <div class="p-2 col-sm-2 text-right" >Totale imponibile</div>
        </div>

        @foreach($orders as $order)
            <div class="text-dark d-flex flex-row bg-warning" >
                <div class="p-2 col-sm-9 text-left">{{ $order->date }} - N.{{ $order->number }} - {{ $order->user->name }} - {{ $order->company->business_name }}</div>
                <div class="p-2 col-sm-1 text-right">{{ \App\Order::STATUS[$order->status]}}</div>
                <div class="p-2 col-sm-2 text-right">{{ $order->total_amount }}</div>
            </div>
            <div class="text-secondary d-flex w-100 flex-column align-items-end" >
                <div class="text-primary d-flex flex-row w-100 " >
                    <div class="pl-4 col-8 text-left">Birra</div>
                    <div class="col-1 text-right">Qtà</div>
                    <div class="col-3 text-right">Imponibile</div>
                </div>
                <hr class="w-100 mb-0 mt-0">
                @foreach($order->lines as $line)
                    <div class="text-dark d-flex flex-row w-100" >
                        <div class="pl-4 col-8 text-left">
                            {{ $line['beer']->name }} -
                            {{ $line['beer']->brewery->name}} -
                            {{ $line['beer']->packaging->name}}
                        </div>
                        <div class="col-1 text-right">{{ $line->qty }}</div>
                        <div class="col-3 text-right">{{ $line->price }}</div>
                    </div>
                @endforeach
            </div>

        @endforeach
    </div>
@endsection
