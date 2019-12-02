@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="col-sm mb-0 mt-0 row">
            {{ 'Codice' }};
            {{ 'Birra' }};
            {{ 'Birrificio' }};
            {{ 'Formato' }};
            {{ 'Stile' }};
            {{ 'Descrizione' }};
            {{ 'Stock' }};
            {{ 'Horeca' }};
            {{ 'Acquisto' }};
            {{ 'Sconto' }};
            {{ 'Distribuzione' }};
            {{ 'Margine' }};
        </div>

        @foreach($beers as $beer)
            @if (($beer->brewery->isactive and $beer->isactive) or request()->has('all'))
                <div class="col-sm mb-0 mt-0 row">
                    {{ $beer->code }};
                    {{ $beer->name }};
                    {{ $beer->brewery->name }};
                    {{ $beer->packaging ? $beer->packaging->name : '' }};
                    {{ $beer->style ? $beer->style->name : '' }};
                    {{ str_replace(';', '--', $beer->description) }};
                    {{ $beer->stock }};
                    @if ($beer->price)
                        {{$beer->price->horeca ? number_format($beer->price->horeca,2,',','.') : 0}};
                        {{$beer->price->purchase ? number_format($beer->price->purchase,2,',','.') : 0}};
                        {{$beer->price->discount ? number_format($beer->price->discount,2,',','.') : 0}};
                        {{$beer->price->distribution ? number_format($beer->price->distribution,2,',','.') : 0}};
                        {{$beer->price->margin ? number_format($beer->price->margin,2,',','.') : 0}};
                    @endif
                </div>
            @endif
        @endforeach
    </div>
@endsection
