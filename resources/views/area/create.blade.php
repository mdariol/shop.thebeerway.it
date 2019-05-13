@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create <em>new</em> Area</h1>

        <form method="POST" action="/areas">
            @csrf

            <div class="form-group">
                <label for="name">Area</label>
                <input type="text" name="name" id="name">
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection