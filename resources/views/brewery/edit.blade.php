@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Birrificio</h1>

        <form method="POST" action="/breweries/{{ $brewery->id }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Birrificio</label>
                <input type="text" name="name" id="name" value="{{ $brewery->name }}">
                <label for="isactive">Attivo</label>
                <input type="checkbox" name="isactive" id="isactive" {{ $brewery->isactive ? 'checked' : ''}}>
            </div>

            <input-image :name='@json('logo')' :label='@json('Logo del Birrificio')'
                         @if($brewery->logo) :default='@json(asset("storage/$brewery->logo"))' @endif
                         @error('logo') :error='@json($message)' @enderror></input-image>


            <button class="btn btn-primary">Aggiorna</button>
        </form>
    </div>
@endsection