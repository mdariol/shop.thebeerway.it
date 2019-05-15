@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Styles</h1>
        <a class="btn btn-primary mb-2" href="/styles/create">Add</a>
        @foreach($styles as $style)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="float-left">{{ $style->name }} {{ $style->area ? $style->area->name : '' }}</p>
                    <div class="float-right">
                        <a href="/styles/{{ $style->id }}/edit" class="btn btn-primary">Edit</a>
                        <a href="/styles/{{ $style->id }}/delete" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection