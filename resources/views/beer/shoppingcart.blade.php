@extends('layouts.app')

@section('title')
    Carrello
@endsection

@section('content')

    @if(Session::has('cart'))

        <div class="container">
            <div class="row bg-primary">
                <div class="col-7 text-left">{{ 'Prodotto' }}</div>
                <div class="col-2 text-right">{{ 'Qtà' }}</div>
                <div class="col-3 text-right">{{ 'Importo' }}</div>
            </div>
            @foreach($products as $product)
                <div class="row">
                    <div class="col-7 text-left">{{ $product['packaging'] }} - {{ $product['beer'] }} - {{ $product['brewery'] }} </div>
                    <div class="col-1 border-0 p-0">
                        <a  href="{{'/beers/'.$product['item']->getAttribute('id').'/fixdowncart'}}" >
                            <img src="/Decrementa-TheBeerWay.png" alt="Diminuisci" height="20px" class="p-0">
                        </a>
                    </div>
                    <div class="col-1 text-center border-0 p-0 ">
                        {{$product['qty']}}
                    </div>
                    <div class="col-1 border-0 p-0">
                        <a  href="{{'/beers/'.$product['item']->getAttribute('id').'/fixupcart'}}" >
                            <img src="/Incrementa-TheBeerWay.png" alt="Aumenta" height="20px" class="p-0">
                        </a>
                    </div>

                    <div class="col-2 text-right ">{{ $product['price'] }}</div>
                </div>
                <hr class="w-100 mb-1 mt-1">
            @endforeach
            <div class="row btn-warning">
                <div class="col-8 text-left">{{ 'Totale Carrello Iva e Spese Escluse' }}</div>
                <div class="col-4 text-right">{{ $totalPrice }}</div>
            </div>
            <form method="POST" action="/beers/saveorder">
                @csrf

                <cart :options='@json(auth()->user()->companies)' :default_company='@json(auth()->user()->default_company)' :shipping_addresses='@json($shipping_addresses)' ></cart>

                <div class="form-group">
                    <label class="pt-3" for="delivetynote">Note per la consegna</label>
                    <textarea class="form-control form-control-lg" type="text" name="deliverynote" id="deliverynote" rows="5">{{ $deliverynote}}</textarea>

                    <div class="form-check form-check-inline">
                        <input type="radio" name="transition" id="transition-send" value="send" class="form-check-input d-none" onchange="this.form.submit()">
                        <label for="transition-send" class="form-check-label btn btn-primary">
                            Invia
                        </label>
                    </div>

                    <button class="btn btn-primary mt-2">Salva per dopo</button>
                </div>

            </form>
        </div>
    @else
        <div class="container">
            <div class="row bg-primary">
                <h1>Il carrello è vuoto</h1>
            </div>
        </div>
    @endif


@endsection