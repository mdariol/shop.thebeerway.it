@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $company->business_name }}
            @role('Admin')
                @if($company->is_approved)
                    <small class="far fa-check-circle text-success" data-toggle="collapse"
                           data-target="#company-approval" style="cursor: pointer;"></small>
                @elseif($company->is_rejected)
                    <small class="far fa-times-circle text-danger" data-toggle="collapse"
                           data-target="#company-approval" style="cursor: pointer;"></small>
                @else
                    <small class="far fa-question-circle text-primary" data-toggle="collapse"
                           data-target="#company-approval" style="cursor: pointer;"></small>
                @endif
            @endrole
        </h1>

        @role('Admin')
            <div class="collapse collapsed" id="company-approval">
                @include('company.components.transition')
            </div>
        @endrole

        <dl class="row">
            <dt class="col-md-2">Partita IVA</dt><dd class="col-md-10">IT-{{ $company->vat_number }}</dd>
            <dt class="col-md-2">Indirizzo</dt><dd class="col-md-10">{{ $company->address }}</dd>
            <dt class="col-md-2">Codice SDI</dt><dd class="col-md-10">{{ $company->sdi }}</dd>
            <dt class="col-md-2">E-mail certificata</dt><dd class="col-md-10">{{ $company->pec }}</dd>
        </dl>

        <a href="{{ route('companies.edit', ['id' => $company->id]) }}" class="btn btn-primary mb-5">Modifica</a>

        <section class="mb-5">
            <h3>Indirizzi di Spedizione</h3>

            @if( ! $company->shipping_addresses->count())
                <p>Non hai alcun indirizzo di spedizione per questa società...</p>
            @else
                <p>Gli indirizzi di spedizione della tua società.</p>
            @endif

            <div class="d-flex overflow-auto">
                @foreach($company->shipping_addresses as $shippingAddress)
                    <article class="card flex-shrink-0 mr-3" style="width: 19rem;">
                        <div class="card-body">
                            <form action="{{ route('companies.shipping-addresses.default', ['company' => $company->id, 'shipping_address' => $shippingAddress->id]) }}"
                                  method="POST" class="float-right">
                                @csrf
                                @method('PATCH')

                                <label class="{{ $shippingAddress->is_default ? 'fas' : 'far' }} fa-star" style="cursor: pointer;"
                                       for="is-default-{{ $shippingAddress->id }}"></label>
                                <input type="checkbox" name="is_default" id="is-default-{{ $shippingAddress->id }}"
                                       class="d-none" onchange="this.form.submit()">
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
                            <a href="{{ route('companies.shipping-addresses.edit', ['company' => $company->id, 'shippind_address' => $shippingAddress->id]) }}">Modifica</a>
                        </div>
                    </article>
                @endforeach

                <article class="card text-center flex-shrink-0" style="width: 19rem; border-style: dashed;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h4 class="card-title mb-4">Aggiungi un nuovo Indirizzo di Spedizione</h4>
                        <a href="{{ route('companies.shipping-addresses.create', ['company' => $company->id]) }}" class="btn btn-primary">Aggiungi</a>
                    </div>
                </article>
            </div>
        </section>
    </div>
@endsection
