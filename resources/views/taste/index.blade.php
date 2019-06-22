@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gusti Prevalenti</h1>
        <a class="btn btn-primary mb-2" href="/tastes/create">Nuovo</a>
        @foreach($tastes as $taste)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $taste->name }}</p>
                    <div class="float-right">
                        <a href="/tastes/{{ $taste->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/tastes/{{ $taste->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection