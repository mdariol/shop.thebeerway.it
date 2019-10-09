@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Società</h1>

        <p class="mb-4">Elenco delle società.</p>

        <div class="card bg-light mb-4">
            <div class="card-header">
                <a href="#filters" class="d-block text-secondary" data-toggle="collapse">Filtri</a>
            </div>
            <div class="card-body collapse" id="filters">
                <form class="mb-0" action="{{ route('admin.companies.index') }}">
                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ request()->name }}">
                        </div>

                        <div class="form-group col-md">
                            <label for="state">Stato</label>
                            <select name="state" id="state" class="form-control">
                                <option selected value> -- seleziona un valore -- </option>
                                @foreach(config('state-machine.approval.states') as $state)
                                    <option {{ request()->state == $state ? 'selected' : '' }}
                                            value="{{ $state }}">{{ ucfirst(__("states.$state")) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md">
                            <label for="owner">Proprietario</label>
                            <select name="owner" id="owner" class="form-control">
                                <option value selected> -- seleziona un valore -- </option>
                                @foreach(\App\User::all() as $user)
                                    <option {{ request()->owner == $user->id ? 'selected' : ''}}
                                            value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary">Filtra</button>
                    <a href="{{ route('admin.companies.index') }}" class="btn btn-link">Reset</a>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="d-none d-md-table-cell">#</th>
                    <th>Nome</th>
                    <th class="d-none d-md-table-cell">Proprietario</th>
                    <th class="d-none d-md-table-cell">Indirizzo</th>
                    <th>Stato</th>
                    <th>Operazioni</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td class="d-none d-md-table-cell align-middle">{{ $company->id }}</td>
                        <td class="align-middle">
                            <a href="{{ route('companies.show', ['company' => $company->id]) }}">{{ $company->business_name }}</a>
                        </td>
                        <td class="d-none d-md-table-cell align-middle">{{ $company->owner->name }}</td>
                        <td class="d-none d-md-table-cell align-middle">{{ $company->address }}</td>
                        <td class="align-middle">
                            <state-machine :action='@json(route('companies.approve', ['company' => $company->id]))'
                                           @if($company->is_pending)
                                           :message='@json("Questa società deve essere verificata. Cosa vuoi fare?")'
                                           @elseif($company->is_approved)
                                           :message='@json("Questa società è stata approvata. Hai cambiato idea?")'
                                           @else
                                           :message='@json('Questa società è stata rifiutata. Hai cambiato idea?')'
                                           @endif
                                           :transitions='@json(array_values($company->state_machine->getPossibleTransitions()))'
                                           :state='@json($company->state)'></state-machine>
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('companies.edit', ['id' => $company->id]) }}"
                               class="btn btn-primary">Modifica</a>
                            <a href="{{ route('companies.delete', ['company' => $company->id]) }}"
                               class="btn btn-link">Elimina</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @empty($companies)
            <p style="padding-left: .75rem;">Non c'è alcuna società...</p>
        @endempty
    </div>
@endsection
