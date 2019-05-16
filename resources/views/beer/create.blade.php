@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create <em>new</em> Beer</h1>

        <form method="POST" action="/beers">
            @csrf

            <div class="form-group">
                <label for="name">Beer</label>
                <input type="text" name="name" id="name">
            </div>

            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" name="code" id="code">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="abv">ABV</label>
                <input type="number" name="abv" id="abv">
            </div>

            <div class="form-group">
                <label for="ibu">IBU</label>
                <input type="number" name="ibu" id="ibu">
            </div>

            <div class="form-group">
                <label for="plato">Plato</label>
                <input type="number" name="plato" id="plato">
            </div>

            <div class="form-group">
                <label for="brewery-id">Brewery</label>
                <select class="form-control" name="brewery_id" id="brewery-id">
                    <option value=" ">-- select an option --</option>
                    @foreach($breweries as $brewery)
                        <option value="{{ $brewery->id }}">{{ $brewery->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="packaging-id">Packaging</label>
                <select class="form-control" name="packaging_id" id="packaging-id">
                    <option value=" ">-- select an option --</option>
                    @foreach($packagings as $packaging)
                        <option value="{{ $packaging->id }}">{{ $packaging->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="style-id">Style</label>
                <select class="form-control" name="style_id" id="style-id">
                    <option value=" ">-- select an option --</option>
                    @foreach($styles as $style)
                        <option value="{{ $style->id }}">{{ $style->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection