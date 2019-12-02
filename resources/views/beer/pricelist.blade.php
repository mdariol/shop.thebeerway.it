@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-dark mb-2 btn-lg" href="/pricelist/download">Scarica</a>


        <table class="table table-sm">
            <thead>
                <th>{{ 'Codice' }}</th>
                <th>{{ 'Birra' }}</th>
                <th>{{ 'Birrificio' }}</th>
                <th>{{ 'Formato' }}</th>
                <th>{{ 'Stile' }}</th>
                <th>{{ 'Descrizione' }}</th>
                <th>{{ 'Prezzo' }}</th>
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
                            @if ($beer->price)
                                <td>{{$beer->price->distribution ? number_format($beer->price->distribution,2,',','.') : 0}}</td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
