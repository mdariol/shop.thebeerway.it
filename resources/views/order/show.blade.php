@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('placed'))
            <div class="alert alert-success">
                {{ session('placed') }}
            </div>
        @endif

        <div class="d-flex">
            <h1>Ordine n°{{ $order->number }}</h1>
            @hasrole('Admin')
            <state-machine :action='@json(route('orders.transition', ['order' => $order->id]))'
                           :transitions='@json(array_values($order->state_machine->getPossibleTransitions()))'
                           :message='@json('Sei pronto a portare avanti questo ordine?')'
                           :state='@json($order->state)' class="ml-4 pt-1"></state-machine>
            @endhasrole
        </div>
        <p class="mb-4">Il tuo ordine è stato <strong>{{ __("states.$order->state") }}</strong>.</p>

        <div class="row">
            <div class="col-md mb-3">
                <div class="card">
                    <h5 class="card-header">Fatturare a...</h5>
                    <div class="card-body">
                        <h4 class="text-truncate">
                            {{ $order->billing_profile->name }}
                            <small class="text-muted ml-2">IT-{{ $order->billing_profile->vat_number }}</small>
                        </h4>
                        <p class="mb-0">{{ $order->billing_profile->address }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md mb-4">
                <div class="card">
                    <h5 class="card-header">Spedire a...</h5>
                    <div class="card-body">
                        <h4 class="text-truncate">
                            {{ $order->shipping_address->name }}
                        </h4>
                        <p class="mb-0">{{ $order->shipping_address->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($order->deliverynote)
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Note di Spedizione</h5>
                    <p class="mb-0">{{ $order->deliverynote }}</p>
                </div>
            </div>
        @endif

        <h3>Carrello</h3>
        <cart :cart='@json($order)' :edit="false"></cart>
    </div>
@endsection
