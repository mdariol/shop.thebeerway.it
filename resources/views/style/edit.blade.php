@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Edit</em> Style</h1>

        <form method="POST" action="/styles/{{ $style->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Style</label>
                <input type="text" name="name" id="name" value="{{ $style->name }}">
            </div>
            <div class="form-group">
                <label for="area_id">Area</label>
                <select class="form-control" name="area_id" id="area_id">
                    <option label=" ">-- Select an option --</option>
                    @foreach($areas as $area)
                        <option {{ $style->area == $area ? 'selected' : '' }} value="{{ $area->id }}">
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection