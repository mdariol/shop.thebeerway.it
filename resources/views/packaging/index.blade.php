@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Packagings</h1>
        <a class="btn btn-primary mb-2" href="/packagings/create">Add</a>
        @foreach($packagings as $packaging)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $packaging->is_bottle }} {{ $packaging->name }} {{ $packaging->quantity }} {{ $packaging->capacity }}</p>
                    <div class="float-right">
                        <a href="/packagings/{{ $packaging->id }}/edit" class="btn btn-primary">Edit</a>
                        <a href="/packagings/{{ $packaging->id }}/delete" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection