@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Utenti</h1>

        <p class="mb-4">Elenco degli utenti.</p>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
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
                            <td class="align-middle">{{ $user->name }}</td>
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

