@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Packagings</h1>
        <a class="btn btn-primary mb-2" href="/packagings/create">Add</a>

        <div class="card">
            <div class="card-body row">
                <div class="col">
                    Name
                </div>
                <div class="col text-center">
                    quantity
                </div>
                <div class="col text-center">
                    capacity
                </div>
                <div class="col text-center">
                    Operations
                </div>
            </div>
        </div>
        @foreach($packagings as $packaging)
            <div class="card">
                <div class="card-body row">
                    <div class="col">
                        {{ $packaging->name }}
                    </div>
                    <div class="col text-center">
                        {{ $packaging->quantity }}
                    </div>
                    <div class="col text-center">
                        {{$packaging->capacity/100}}
                    </div>

                    <div class="col text-center">
                        <a href="/packagings/{{ $packaging->id }}/edit" class="btn btn-primary">Edit</a>
                        <a href="/packagings/{{ $packaging->id }}/delete" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection