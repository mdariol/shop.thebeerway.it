@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('checkout.process') }}" id="checkout">
            @csrf

            <checkout :billing-profiles='@json($billingProfiles)' :errors='@json($errors->get('*'))'
                      :cart='@json($cart)' :policy='@json($policy)'></checkout>
        </form>
    </div>
@endsection
