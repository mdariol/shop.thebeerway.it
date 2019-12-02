@extends('layouts.app')

@section('content')
    <div class="container">

        <table class="table table-sm">
            <thead>
                <th>{{ 'Codice' }}</th>
                <th>{{ 'Birra' }}</th>
                <th>{{ 'Birrificio' }}</th>
                <th>{{ 'Formato' }}</th>
                <th>{{ 'Stile' }}</th>
                <th>{{ 'Descrizione' }}</th>
                <th>{{ 'Stock' }}</th>
                <th>{{ 'Horeca' }}</th>
                <th>{{ 'Acquisto' }}</th>
                <th>{{ 'Sconto' }}</th>
                <th>{{ 'Distribuzione' }}</th>
                <th>{{ 'Margine' }}</th>
            </thead>
            <tbody>
                @foreach($beers as $beer)
                    @if (($beer->brewery->isactive and $beer->isactive) or request()->has('all'))
                        <tr>
                            <td>{{ $beer->code }}</td>
                            <td>{{ $beer->name }}</td>
                            <td>{{ $beer->brewery->name }}</td>
                            <td>{{ $beer->packaging ? $beer->packaging->name : '' }}</td>
                            <td>{{ $beer->style ? $beer->style->name : '' }}</td>
                            <td>{{ str_replace(';', '--', $beer->description) }}</td>
                            <td>{{ $beer->stock }}</td>
                            @if ($beer->price)
                                <td>{{$beer->price->horeca ? number_format($beer->price->horeca,2,',','.') : 0}}</td>
                                <td>{{$beer->price->purchase ? number_format($beer->price->purchase,2,',','.') : 0}}</td>
                                <td>{{$beer->price->discount ? number_format($beer->price->discount,2,',','.') : 0}}</td>
                                <td>{{$beer->price->distribution ? number_format($beer->price->distribution,2,',','.') : 0}}</td>
                                <td>{{$beer->price->margin ? number_format($beer->price->margin,2,',','.') : 0}}</td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
