@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-md-flex mb-5">
            <div style="width: 10rem; height: 10rem; border-radius: 50%; background-image: url({{ "/storage/$user->profile_image" }}); background-color: rgba(0, 0, 0, 0.03); background-size: cover;"
                 class="mx-auto mx-md-0 mr-md-3 mb-3 mb-md-0"></div>

            <div class="flex-grow-1 align-self-center text-center text-md-left">
                <h1>{{ $user->name }}</h1>
                <p>{{ $user->email }}
                    <email-verified :verified='@json($user->hasVerifiedEmail())'
                                    :url='@json(route('verification.resend'))'></email-verified></p>

                <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary">Modifica</a>
            </div>
        </div>

        <section>
            <h3>Profili di Fatturazione</h3>

            @empty($user->billing_profiles)
                <p>Non hai alcun profilo di fatturazione...</p>
            @else
                <p>I tuoi profili di fatturazione.</p>
            @endempty

            <div class="d-flex overflow-auto">
                @foreach($user->billing_profiles as $billingProfile)
                    <div class="card mr-3 flex-shrink-0" style="width: 19rem;">
                        <div class="card-body">
                            <form action="{{ route('billing-profiles.default', ['billing-profile' => $billingProfile->id]) }}"
                                  method="POST" class="float-right">
                                @csrf
                                @method('PATCH')

                                <button class="{{ $billingProfile->is_default ? 'fas' : 'far' }} fa-star btn-none"></button>
                            </form>
                            <h4 class="card-title text-truncate mr-4">
                                <a href="{{ route('billing-profiles.show', ['id' => $billingProfile->id]) }}">{{ $billingProfile->name }}</a>
                            </h4>
                            <hr>
                            <small class="text-muted">IT-{{ $billingProfile->vat_number }}</small>
                            <p class="mb-0">{{ $billingProfile->address }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('billing-profiles.edit', ['billing-profile' => $billingProfile->id]) }}" class="card-link">Modifica</a>
                            <a href="{{ route('billing-profiles.show', ['billing-profile' => $billingProfile->id]) }}" class="card-link">Indirizzi di Spedizione</a>
                        </div>
                    </div>
                @endforeach

                <div class="card flex-shrink-0" style="width: 19rem; border-style: dashed">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h4 class="card-title text-center mb-4">Aggiungi un nuovo Profilo di Fatturazione</h4>
                        <a href="{{ route('billing-profiles.create') }}" class="btn btn-primary">Aggiungi</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
