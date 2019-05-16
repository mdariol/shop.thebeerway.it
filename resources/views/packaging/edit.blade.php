@extends('layouts.app')

@section('content')



    <div class="container">
        <h1>Edit <em>new</em> Packaging</h1>


        <form method="POST" action="/packagings/{{ $packaging->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="is-bottle">Is Bottle</label>
                <input type="checkbox" name="is_bottle" id="is-bottle" {{ $packaging->is_bottle == true ? 'checked' : '' }}>
            </div>
            <div class="form-group">
                <label for="name">Packaging</label>
                <input type="text" name="name" id="name" value="{{ $packaging->name }}">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{ $packaging->quantity }}">
            </div>
            <div class="form-group">
                <label for="capacity">Unit Capacity Lt</label>
                <input type="number" name="capacity" step=".01" id="capacity" value="{{ $packaging->capacity }}">
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>

@endsection