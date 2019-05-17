@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Breweries</h1>
        <a class="btn btn-primary mb-2" href="/breweries/create">Add</a>
        @foreach($breweries as $brewery)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $brewery->name }}</p>
                    <div class="float-right">
                        <a href="/breweries/{{ $brewery->id }}/edit" class="btn btn-primary">Edit</a>
                        <a href="/breweries/{{ $brewery->id }}/delete" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection