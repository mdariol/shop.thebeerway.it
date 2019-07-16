@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica il tuo indirizzo email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Abbiamo inviato un link di verifica al tuo indirizzo email.') }}
                        </div>
                    @endif

                    {{ __('Prima di proseguire controlla la presenza nella tua email del link di verifica.') }}
                    {{ __('Se non ricevi la nostra email') }}, <a href="{{ route('verification.resend', ['user' => request()->user]) }}">{{ __('clicca qui per inviarne una nuova') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
