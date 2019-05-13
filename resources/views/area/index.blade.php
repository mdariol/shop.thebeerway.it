@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Areas</h1>
        <a class="btn btn-primary mb-2" href="/areas/create">Add</a>
        @foreach($areas as $area)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $area->name }}</p>
                    <div class="float-right">
                        <a href="/areas/{{ $area->id }}/edit" class="btn btn-primary">Edit</a>
                        <a href="/areas/{{ $area->id }}/delete" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection