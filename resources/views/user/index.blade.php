@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Utenti</h1>

        <!--
        <a class="btn btn-primary mb-2" href="/roles/create">Nuovo</a>
        -->
        @foreach($users as $user)
            <form method="POST" action="/roleassign">
                @csrf

                <div class="card mb-2">
                    <div class="card-body">
                        <p class="float-left mr-5">{{ $user->name }} {{ $user->ishoreca ? '( '.$user->horecaname.' - '.$user->vatnumber.' )'.' - '.$user->email : ''}} </p>
                        <div class="float-right">
                            <button class="btn btn-primary">Assegna Ruoli</button>
                        </div>
                        @foreach ($roles as $role)
                            <div class="form-check form-check-inline" >
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : ''}}  aria-label="Checkbox for following text input">
                                <label class="form-check-label">{{$role->name}} </label>
                                <input class="form-control" type=text" name="assign_user" value="{{ $user->id }}"  hidden>
                            </div>
                        @endforeach

                        <div class="float-right">
                            <a href="/users/{{ $user->id }}/edit" class="btn btn-primary">Modifica</a>
                            <a href="/users/{{ $user->id }}/delete" class="btn btn-danger">Elimina</a>
                        </div>

                    </div>
                </div>
            </form>
        @endforeach
    </div>
@endsection

