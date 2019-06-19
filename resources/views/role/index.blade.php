@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ruoli</h1>
        <a class="btn btn-primary mb-2" href="/roles/create">Nuovo</a>
        @foreach($roles as $role)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $role->name }}</p>
                    <div class="float-right">
                        <a href="/roles/{{ $role->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/roles/{{ $role->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection