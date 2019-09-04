@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3">{{ $company->business_name }}</h1>

        <dl class="row">
            <dt class="col-md-2">Partita IVA</dt><dd class="col-md-10">IT-{{ $company->vat_number }}</dd>
            <dt class="col-md-2">Indirizzo</dt><dd class="col-md-10">{{ $company->address }}</dd>
            <dt class="col-md-2">Codice SDI</dt><dd class="col-md-10">{{ $company->sdi }}</dd>
            <dt class="col-md-2">E-mail certificata</dt><dd class="col-md-10">{{ $company->pec }}</dd>
        </dl>

        <a href="{{ route('companies.edit', ['id' => $company->id]) }}" class="btn btn-primary mb-5">Modifica</a>

        <section class="mb-5">
            <h3>Indirizzi di Spedizione</h3>

            <div class="d-flex overflow-auto">
                @foreach($company->shippingAddresses as $shippingAddress)
                    <article class="card flex-shrink-0 mr-3" style="width: 19rem;">
                        <div class="card-body">
                            <h4 class="card-title">{{ $shippingAddress->name }}</h4>
                            <hr>
                            <p><strong>Indirizzo:</strong><br>
                                {{ $shippingAddress->address }}</p>
                            @if($shippingAddress->phone)
                                <p class="mb-0"><strong>Telefono:</strong><br>
                                    {{ $shippingAddress->phone }}</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('shipping-addresses.edit', ['company' => $company->id, 'shippind-address' => $shippingAddress->id]) }}">Modifica</a>
                        </div>
                    </article>
                @endforeach

                <article class="card text-center flex-shrink-0" style="width: 19rem; border-style: dashed;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h4 class="card-title mb-4">Aggiungi un nuovo Indirizzo di Spedizione</h4>
                        <a href="{{ route('shipping-addresses.create', ['company' => $company->id]) }}" class="btn btn-primary">Aggiungi</a>
                    </div>
                </article>
            </div>
        </section>
    </div>
@endsection
