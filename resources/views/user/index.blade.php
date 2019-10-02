@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Utenti</h1>

        <p class="mb-4">Elenco degli utenti.</p>

        <div class="card bg-light mb-4">
            <div class="card-header">
                <a href="#filters" class="d-block text-secondary" data-toggle="collapse">Filtri</a>
            </div>
            <div class="card-body collapse" id="filters">
                <form class="mb-0" action="{{ route('users.index') }}">
                    <div class="form-row">
                        <div class="form-group col-md">
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ request()->name }}">
                        </div>

                        <div class="form-group col-md">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ request()->email }}">
                        </div>

                        <div class="form-group col-md">
                            <label for="role">Ruolo</label>
                            <select name="role" id="role" class="form-control">
                                <option selected value> -- seleziona un valore -- </option>
                                @foreach($roles as $role)
                                    <option {{ request()->role == $role->id ? 'selected' : '' }}
                                            value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-primary">Filtra</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link">Reset</a>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="d-none d-md-table-cell">#</th>
                    <th>Nome</th>
                    <th class="d-none d-md-table-cell">Email</th>
                    @foreach($roles as $role)
                        <th>{{ $role->name }}</th>
                    @endforeach
                    <th>Operazioni</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="d-none d-md-table-cell align-middle">{{ $user->id }}</td>
                            <td class="align-middle">
                                <a href="{{ route('users.show', ['user' => $user->id]) }}">{{ $user->name }}</a>
                            </td>
                            <td class="d-none d-md-table-cell align-middle">{{ $user->email }}</td>
                            @foreach($roles as $role)
                                <td class="align-baseline">
                                    <form method='POST' action="{{ route('users.role', ['user' => $user->id]) }}">
                                        @csrf
                                        @method('PATCH')

                                        <div class="form-check">
                                            <input type="checkbox" name="remove" class="form-check-input d-none"
                                                   value="{{ $role->name }}" checked>
                                            <input class="form-check-input" type="checkbox" name="role"
                                                   {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                   id="role-{{ $role->name . '-' . $user->id }}"
                                                   value="{{ $role->name }}" onchange="this.form.submit()">
                                            <label for="role-{{ $role->name . '-' . $user->id }}"
                                                   class="form-check-label d-none">{{ $role->name }}</label>
                                        </div>
                                    </form>
                                </td>
                            @endforeach
                            <td class="align-middle">
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-primary">Modifica</a>
                                <a href="{{ route('users.delete', ['user' => $user->id]) }}" class="btn btn-link">Elimina</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection

