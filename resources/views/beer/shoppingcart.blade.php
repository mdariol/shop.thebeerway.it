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
                    <div class="col-7 text-left">
                        {{ $product['packaging'] }} -
                        {{ $product['beer'] }} -
                        {{ $product['brewery'] }} [
                        {{ $beers->find($product['item']->getAttribute('id'))->stock - $beers->find($product['item']->getAttribute('id'))->requested_stock}}]
                    </div>
                    <div class="col-1 border-0 p-0">
                        <a  href="{{'/beers/'.$product['item']->getAttribute('id').'/fixdowncart'}}" >
                            <img src="/Decrementa-TheBeerWay.png" alt="Diminuisci" height="20px" class="p-0">
                        </a>
                    </div>
                    @if ($product['qty'] > $beers->find($product['item']->getAttribute('id'))->stock - $beers->find($product['item']->getAttribute('id'))->requested_stock)
                        <div class="col-1 text-center border-0 p-0 bg-danger ">
                            {{$product['qty']}}
                        </div>
                    @else
                        <div class="col-1 text-center border-0 p-0 ">
                            {{$product['qty']}}
                        </div>
                    @endif
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
            <form method="POST" action="/beers/saveorder" >
                @csrf

                @if (auth()->user()->hasRole('Publican'))
                    <cart :options='@json(auth()->user()->billing_profiles)' :default_company='@json(auth()->user()->default_billing_profile)' :shipping_addresses='@json($shipping_addresses)' ></cart>
                @else
                    <cart :options='@json($billing_profiles)' :shipping_addresses='@json($shipping_addresses)' ></cart>
                @endif

                <div class="form-group">
                    <label class="pt-3" for="delivetynote">Note per la consegna</label>
                    <textarea class="form-control form-control-lg" type="text" name="deliverynote" id="deliverynote" rows="5">{{ $deliverynote}}</textarea>


                    <label class="pt-3" for="current_policy">Condizioni di vendita</label>
                    <textarea readonly class="form-control form-control-lg" type="text" name="current_policy" id="current_policy" rows="5">{{ $current_policy->content}}</textarea>

                    <div class="form-check form-check-inline w-100">

                        <input type="checkbox" name="accept" id="accept" class="form-control-sm">
                        <label for="accept" class="form-control form-check-label border-0">
                            Accetto le condizioni di vendita
                        </label>

                    </div>
                    <div class="form-check form-check-inline">

                        <button name="transition" value="send" class="btn btn-primary mt-2" onclick="checkForm(event)">
                            Invia richiesta
                        </button>

                        <button name="save_cart" value="savecart" class="btn btn-warning mt-2 ml-2">
                            Salva il carrello
                        </button>

                        <button name="reset_cart" value="resetcart"  class="btn btn-danger mt-2 ml-2">
                            Svuota il carrello
                        </button>
                    </div>

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

<script>

    function checkForm(event)
    {
        console.log(event.target);
        console.log(event.target.form);

        console.log(event);
        if(!event.target.form.accept.checked) {
            alert("Per continuare è necessario accettare le condizioni di vendita");
            event.preventDefault();
            event.target.form.accept.focus();
        }
    }

</script>
