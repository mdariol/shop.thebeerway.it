@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Edit</em> Beer</h1>

        <form method="POST" action="/beers/{{ $beer->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Beer</label>
                <input type="text" name="name" id="name" value="{{ $beer->name }}">
            </div>

            <div class="form-group">
                <label for="code">Code</label>
                <input type="text" name="code" id="code" value="{{ $beer->code }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3">{{ $beer->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="abv">ABV</label>
                <input type="number" name="abv" id="abv" value="{{ $beer->abv }}" step=".1">
            </div>

            <div class="form-group">
                <label for="ibu">IBU</label>
                <input type="number" name="ibu" id="ibu" value="{{ $beer->ibu }}" step=".1">
            </div>

            <div class="form-group">
                <label for="plato">Plato</label>
                <input type="number" name="plato" id="plato" value="{{ $beer->plato }}" step=".1">
            </div>

            <div class="form-group">
                <label for="brewery-id">Brewery</label>
                <select class="form-control" name="brewery_id" id="brewery-id">
                    <option value=" ">-- select an option --</option>
                    @foreach($breweries as $brewery)
                        <option value="{{ $brewery->id }}" {{ $beer->brewery == $brewery ? 'selected' : '' }}>{{ $brewery->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="packaging-id">Packaging</label>
                <select class="form-control" name="packaging_id" id="packaging-id">
                    <option value=" ">-- select an option --</option>
                    @foreach($packagings as $packaging)
                        <option value="{{ $packaging->id }}" {{ $beer->packaging == $packaging ? 'selected' : '' }}>{{ $packaging->quantity }} {{ $packaging->name }} x @ClToLt($packaging->capacity)l</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="style-id">Style</label>
                <select class="form-control" name="style_id" id="style-id">
                    <option value=" ">-- select an option --</option>
                    @foreach($styles as $style)
                        <option value="{{ $style->id }}" {{ $beer->style == $style ? 'selected' : '' }}>{{ $style->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection