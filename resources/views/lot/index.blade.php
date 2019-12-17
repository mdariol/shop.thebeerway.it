@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lotti</h1>
        <p>Elenco dei lotti.</p>
        <a href="{{ route('admin.lots.create') }}" class="btn btn-primary mb-4">Aggiungi</a>

        @include('lot.partials.filters')

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Birra</th>
                    <th>Magazzino</th>
                    <th>Ordinato</th>
                    <th>Disponibile</th>
                    <th>Imbottigliato</th>
                    <th>Scadenza</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lots as $lot)
                    <tr>
                        <td class="align-middle">
                            <a href="{{ route('admin.lots.show', ['lot' => $lot->id]) }}">{{ $lot->number }}</a>
                        </td>
                        <td>
                            {{ $lot->beer->name }}
                            <span class="text-muted ml-1">{{ $lot->beer->brewery->name }}</span><br>
                            <small>{{ $lot->beer->packaging->name }}</small>
                        </td>
                        <td class="align-middle">{{ $lot->stock }}</td>
                        <td class="align-middle">{{ $lot->reserved }}</td>
                        <td class="align-middle">{{ $lot->available }}</td>
                        <td class="align-middle">
                            @if($lot->bottled_at) {{ $lot->bottled_at->format('d-m-Y') }} @endif
                        </td>
                        <td class="align-middle">
                            @if($lot->expires_at) {{ $lot->expires_at->format('d-m-Y') }} @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if($lots->isEmpty())
                <p class="ml-2">Nessun lotto a magazzino...</p>
            @endif
        </div>
    </div>
@endsection
