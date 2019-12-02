@extends('layouts.app')

@section('content')
    <div class="container col-md-5">
        <div class="card">
            <div class="card-header">
                Con quale utente vuoi fare il login?
            </div>
            <div class="card-body">
                <form method="POST" action="/login-as">
                    @csrf

                    <input-autocomplete :route='@json(route('users.index'))' :search-by='@json('email')'
                                        :label='@json('Utente')' :option-label='@json('email')' :name='@json('user_id')'
                                        @error('user_id') :error='@json($message)' @enderror
                                        :description='@json("Seleziona l'utente con il quale fare il login.")'></input-autocomplete>

                    <button class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
