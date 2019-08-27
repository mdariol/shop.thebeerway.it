@extends('layouts.app')

@section('content')
    <div class="container">


    @foreach($beers as $beer)
            <div class="col-sm mb-0 mt-0 row">
                    {{ $beer->name }};
                    {{ $beer->brewery->name }};
                    {{ $beer->packaging ? $beer->packaging->name : '' }};
                    @if ($beer->price)
                        {{$beer->price->horeca ? $beer->price->horeca : 0}};
                        {{$beer->price->purchase ? $beer->price->purchase : 0}};
                        {{$beer->price->discount ? $beer->price->discount : 0}};
                        {{$beer->price->distribution ? $beer->price->distribution : 0}};
                        {{$beer->price->margin ? $beer->price->margin : 0}};
                    @endif
            </div>
        @endforeach
    </div>
@endsection