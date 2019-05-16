@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create <em>new</em> Packaging</h1>

        <form method="POST" action="/packagings">
            @csrf

            <div class="form-group">
                <label for="is-bottle">Is Bottle</label>
                <input type="checkbox" name="is_bottle" id="is-bottle" unchecked>
            </div>
            <div class="form-group">
                <label for="name">Packaging</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity">
            </div>
            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" name="capacity" id="capacity">
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection