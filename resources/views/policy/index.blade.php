@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Policies</h1>
        <a class="btn btn-primary mb-2" href="/policies/create">Nuova</a>

        <div class="card">
            <div class="card-body row">
                <div class="col">
                    Nome
                </div>
                <div class="col text-center">
                    Contenuto
                </div>
                <div class="col text-center">
                    Dalla data
                </div>
                <div class="col text-center">
                    Operazioni
                </div>

            </div>
        </div>
        @foreach($policies as $policy)
            <div class="card">
                <div class="card-body row">
                    <div class="col">
                        {{ $policy->name }}
                    </div>
                    <div class="col text-center">
                        {{ $policy->content }}
                    </div>
                    <div class="col text-center">
                        {{$policy->from_date}}
                    </div>

                    <div class="col text-center">
                        <a href="/policies/{{ $policy->id }}/edit" class="btn btn-primary">Modifica</a>
                        <a href="/policies/{{ $policy->id }}/delete" class="btn btn-danger">Elimina</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection