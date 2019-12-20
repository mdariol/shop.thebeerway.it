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
                    <th>Ordinato</th>
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
                    <td>
                        @if($lot->bottled_at) {{ $lot->bottled_at->format('Y-m-d') }} @endif
                    </td>
                    <td>
                        @if($lot->expires_at) {{ $lot->expires_at->format('Y-m-d') }} @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <h2>Movimenti</h2>

        @if($lot->movements->isEmpty())
            <p>Nessun movimento registrato...</p>
        @endif

        <ul class="list-group list-group-flush">
            @foreach($lot->movements as $movement)
                <li @if($movement->reverted()) style="text-decoration: line-through" @endif
                    class="p-2 list-group-item bg-transparent">
                    @if($movement->agent) {{ $movement->agent->name }} @else WareBot @endif ha {{ $movement->action }}
                    {{ $movement->quantity }} unità di {{ $lot->beer->name }} il
                    {{ $movement->created_at->format('d-m-Y') }} alle {{ $movement->created_at->format('H:m:s') }}.
                </li>
            @endforeach
        </ul>
    </div>
@endsection
