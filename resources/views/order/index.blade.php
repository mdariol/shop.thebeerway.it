@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card-header m-0 pl-0 pr-0 pt-0 pb-2 border-0">
            <h1  class="btn btn-dark btn-lg m-0 p-0 w-100 border-0" data-toggle="collapse" role="button" data-target="#filter">
                <img src="/Imbuto-TheBeerWay.png" alt="Carrello" height="20px" >
                Filtri
            </h1>
        </div>

        <div class="card-body collapse" id="filter">
            <form method="GET" action="/orders">

                <div class="form-group col-md">
                    <label for="state">Stato</label>
                    <select name="state" id="state" class="form-control">
                        <option selected value> -- seleziona un valore -- </option>
                        @foreach(config('state-machine.orderflow.states') as $state)
                            <option value="{{ $state }}"
                                {{ request()->state == $state ? 'selected' : '' }}>
                                {{__("states.$state")}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md">
                    <label for="date_from">Dalla data</label>
                    <input type="date" class="form-control" name="date_from" id="date_from" value="{{ request()->date_from }}">
                </div>

                <div class="form-group col-md">
                    <label for="date_to">Alla data</label>
                    <input type="date" class="form-control" name="date_to" id="date_to" value="{{ request()->date_to }}">
                </div>

                <div class="form-group col-md">
                    <label for="brewery_id">Contengo il Birrificio</label>
                    <select name="brewery_id" id="brewery_id" class="form-control">
                        <option selected value> -- seleziona un valore -- </option>
                        @foreach( $breweries as $brewery)
                            <option value="{{ $brewery->id }}"
                                    {{ request()->brewery_id == $brewery->id ? 'selected' : '' }}>
                                {{ $brewery->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md">
                    <label for="total_amount_from">Totale a partire da</label>
                    <input type="text" class="form-control" name="total_amount_from" id="total_amount_from" value="{{ request()->total_amount_from }}">
                </div>
                <div class="form-group col-md">
                    <label for="total_amount_to">Totale fino a</label>
                    <input type="text" class="form-control" name="total_amount_to" id="total_amount_to" value="{{ request()->total_amount_to }}">
                </div>

                <button class="btn btn-primary">Applica Filtri</button>
                <a href="/orders" class="btn btn-link">Reset Filtri</a>

            </form>
        </div>

        <div class="text-white d-flex flex-row bg-dark" >
            <div class="p-2 col-sm-9 text-left" >Ordine</div>
            <div class="p-2 col-sm-1 text-right">Stato</div>
            <div class="p-2 col-sm-2 text-right" >Totale imponibile</div>
        </div>

        @foreach($orders as $order)
            <div class="text-dark d-flex flex-row bg-warning" >
                <div class="p-2 col-sm-9 text-left">{{ $order->date }} - {{ $order->number }}/{{$order->id}} - {{ $order->user->name }} - {{ $order->company->business_name }}</div>
                <div class="p-2 col-sm-1 text-right">{{ __("states.$order->state")}}</div>
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
