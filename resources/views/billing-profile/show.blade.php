@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $billingProfile->name }}
            @role('Admin')
                @if($billingProfile->is_approved)
                    <small class="far fa-check-circle text-success" data-toggle="collapse"
                           data-target="#billing-profile-approval" style="cursor: pointer;"></small>
                @elseif($billingProfile->is_rejected)
                    <small class="far fa-times-circle text-danger" data-toggle="collapse"
                           data-target="#billing-profile-approval" style="cursor: pointer;"></small>
                @else
                    <small class="far fa-question-circle text-primary" data-toggle="collapse"
                           data-target="#billing-profile-approval" style="cursor: pointer;"></small>
                @endif
            @endrole
        </h1>

        @role('Admin')
            <div class="collapse collapsed" id="billing-profile-approval">
                @include('billing-profile.components.transition')
            </div>
        @endrole

        <dl class="row">
            <dt class="col-md-2">Partita IVA</dt><dd class="col-md-10">IT-{{ $billingProfile->vat_number }}</dd>
            <dt class="col-md-2">Indirizzo</dt><dd class="col-md-10">{{ $billingProfile->address }}</dd>
            @if($billingProfile->sdi) <dt class="col-md-2">Codice SDI</dt><dd class="col-md-10">{{ $billingProfile->sdi }}</dd> @endif
            @if($billingProfile->pec) <dt class="col-md-2">E-mail certificata</dt><dd class="col-md-10">{{ $billingProfile->pec }}</dd> @endif
        </dl>

        <a href="{{ route('billing-profiles.edit', ['id' => $billingProfile->id]) }}" class="btn btn-primary mb-5">Modifica</a>

        <section class="mb-5">
            <h3>Indirizzi di Spedizione</h3>

            @empty($billingProfile->shipping_addresses)
                <p>Non hai alcun indirizzo di spedizione per questo profilo di fatturazione...</p>
            @else
                <p>Gli indirizzi di spedizione del tuo profilo.</p>
            @endempty

            <div class="d-flex overflow-auto">
                @foreach($billingProfile->shipping_addresses as $shippingAddress)
                    <article class="card flex-shrink-0 mr-3" style="width: 19rem;">
                        <div class="card-body">
                            <form action="{{ route('billing-profiles.shipping-addresses.default', ['billing-profile' => $billingProfile->id, 'shipping_address' => $shippingAddress->id]) }}"
                                  method="POST" class="float-right">
                                @csrf
                                @method('PATCH')

                                <button class="{{ $shippingAddress->is_default ? 'fas' : 'far' }} fa-star btn-none"></button>
                            </form>
                            <h4 class="card-title text-truncate mr-4">{{ $shippingAddress->name }}</h4>
                            <hr>
                            <p><strong>Indirizzo:</strong><br>
                                {{ $shippingAddress->address }}</p>
                            @if($shippingAddress->phone)
                                <p class="mb-0"><strong>Telefono:</strong><br>
                                    {{ $shippingAddress->phone }}</p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('billing-profiles.shipping-addresses.edit', ['billing-profile' => $billingProfile->id, 'shippind_address' => $shippingAddress->id]) }}">Modifica</a>
                        </div>
                    </article>
                @endforeach

                <article class="card text-center flex-shrink-0" style="width: 19rem; border-style: dashed;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h4 class="card-title mb-4">Aggiungi un nuovo Indirizzo di Spedizione</h4>
                        <a href="{{ route('billing-profiles.shipping-addresses.create', ['billing-profile' => $billingProfile->id]) }}" class="btn btn-primary">Aggiungi</a>
                    </div>
                </article>
            </div>
        </section>
    </div>
@endsection
