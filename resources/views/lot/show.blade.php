@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lotto #{{ $lot->number }}</h1>
        <p class="mb-4">Relativo a <strong>{{ $lot->beer->name }}</strong> di <strong>{{ $lot->beer->brewery->name }}</strong>,
            {{ $lot->beer->packaging->name }}.</p>

        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Magazzino</th>
                    <th>Richiesto</th>
                    <th>Disponibile</th>
                    <th>Imbottigliato</th>
                    <th>Scadenza</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $lot->stock }}</td>
                    <td>{{ $lot->reserved }}</td>
                    <td>{{ $lot->available }}</td>
                    <td>{{ $lot->bottled_at->format('Y-m-d') }}</td>
                    <td>{{ $lot->expires_at->format('Y-m-d') }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h2>Movimenti</h2>
        <p>Nessun movimento registrato...</p>
    </div>
@endsection
