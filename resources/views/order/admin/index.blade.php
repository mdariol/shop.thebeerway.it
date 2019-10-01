@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ordini</h1>

        <p class="mb-4">Elenco degli ordini.</p>

        <div class="card bg-light mb-4">
            <div class="card-header">
                <a href="#filters" class="d-block text-secondary" data-toggle="collapse">Filtri</a>
            </div>
            <div class="card-body collapse" id="filters">
                <form action="{{ route('admin.orders.index') }}" class="mb-0">
                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="number">Numero</label>
                            <input type="text" name="number" id="number" class="form-control"
                                   value="{{ request()->number }}">
                        </div>

                        <div class="form-group col-md">
                            <label for="owner">Utente</label>
                            <input type="text" name="owner" id="owner" class="form-control"
                                   value="{{ request()->owner }}">
                        </div>

                        <div class="form-group col-md">
                            <label for="company">Società</label>
                            <input type="text" name="company" id="company" class="form-control"
                                   value="{{ request()->company }}">
                        </div>

                        <div class="form-group col-md">
                            <label for="state">Stato</label>
                            <select name="state" id="state" class="form-control">
                                <option value selected> -- seleziona un valore -- </option>
                                @foreach(config('state-machine.orderflow.states') as $state)
                                    <option {{ request()->state == $state ? 'selected' : '' }}
                                            value="{{ $state }}">{{ ucfirst(__("states.$state")) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary">Filtra</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-link">Reset</a>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="d-none d-md-table-cell">#</th>
                    <th class="d-none d-md-table-cell">Utente</th>
                    <th>Società</th>
                    <th>Totale</th>
                    <th>Stato</th>
                    <th>Operazioni</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="d-none d-md-table-cell align-middle">{{ $order->number }}</td>
                        <td class="d-none d-md-table-cell align-middle">{{ $order->user->name }}</td>
                        <td class="align-middle">{{ $order->company->business_name }}</td>
                        <td class="align-middle">€ {{ $order->total_amount }}</td>
                        <td class="align-middle">{{ ucfirst(__("states.$order->state")) }}</td>
                        <td>
                            <form method="POST" action="{{ route('orders.transition', ['order' => $order->id]) }}">
                                @csrf
                                @method('PATCH')

                                @foreach($order->state_machine->getPossibleTransitions() as $transition)
                                    <button class="btn {{ $loop->first ? 'btn-primary' : 'btn-link' }}" name="transition"
                                            value="{{ $transition }}">{{ ucfirst(__("states.$transition")) }}</button>
                                @endforeach
                            </form>

                            @if ( ! count($order->state_machine->getPossibleTransitions())) // @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        @if( ! $orders->count())
            <p style="padding-left: .75rem;">Non c'è alcun ordine...</p>
        @endif
    </div>
@endsection
