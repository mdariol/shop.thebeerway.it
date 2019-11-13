@extends('layouts.app')

@section('content')
    <div class="container col-md-5">
        <div class="card">
            <div class="card-header">
                Per chi desideri effettuare l'ordine?
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.orders.create') }}">
                    <input-autocomplete :route='@json(route('users.index'))' :search-by='@json('email')'
                                        :label='@json('Utente')' :option-label='@json('email')' :name='@json('user')'
                                        @error('user') :error='@json($message)' @enderror
                                        :description='@json("Per chi stai facendo l'ordine?")'>
                    </input-autocomplete>

                    <button class="btn btn-primary">Seleziona</button>
                </form>
            </div>
        </div>
    </div>
@endsection
