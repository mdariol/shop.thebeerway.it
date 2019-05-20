@extends('layouts.app')

@section('content')



    <div class="container">
        <h1>Edit <em>new</em> Packaging</h1>


        <form method="POST" action="/packagings/{{ $packaging->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" name="type" id="type">
                    <option label=" ">-- Select an option --</option>
                    @foreach(\App\Packaging::TYPE as $type)
                        <option {{ $packaging->type == $type ? 'selected' : '' }} value="{{ $type }}">
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="{{ $packaging->quantity }}">
            </div>
            <div class="form-group">
                <label for="capacity">Unit Capacity Lt</label>
                <input type="number" name="capacity" step=".01" id="capacity" value="{{ $packaging->capacity/100 }}">
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>

@endsection