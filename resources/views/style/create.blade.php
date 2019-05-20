@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuovo Stile</h1>

        <form method="POST" action="/styles">
            @csrf

            <div class="form-group">
                <label for="name">Stile</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="area_id">Area</label>
                <select class="form-control" name="area_id" id="area_id">
                    <option label=" ">-- Seleziona un'opzione --</option>
                    @foreach($areas as $area)
                        <option value="{{$area->id}}"> {{$area->name}} </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection