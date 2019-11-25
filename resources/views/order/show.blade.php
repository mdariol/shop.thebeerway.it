@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('placed'))
            <div class="alert alert-success">
                {{ session('placed') }}
            </div>
        @endif

        <h1>Ordine n°{{ $order->number }}</h1>
    </div>
@endsection
