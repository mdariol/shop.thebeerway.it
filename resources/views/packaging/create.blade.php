@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create <em>new</em> Packaging</h1>

        <form method="POST" action="/packagings">
            @csrf

            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" name="type" id="type">
                    <option label=" ">-- Select an option --</option>
                    @foreach(\App\Packaging::TYPE as $type)
                        <option value="{{ $type }}">
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" >
            </div>
            <div class="form-group">
                <label for="capacity">Unit Capacity Lt.</label>
                <input type="number" step=".01" name="capacity" id="capacity">
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection