@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Birra</h1>

        <form method="POST" action="{{str_replace('/edit', '', request()->getRequestUri() )}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-row">
                <div class="form-group col-sm-7">
                    <label for="name">Nome</label>
                    <input class="form-control form-control-lg" type="text" name="name" id="name"
                           value="{{ $beer->name }}">
                </div>

                <div class="form-group col-sm-4">
                    <label for="code">Codice</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">#</span></div>
                        <input class="form-control form-control-lg" type="text" name="code" id="code"
                               value="{{ $beer->code }}">
                    </div>
                </div>
                <div class="form-group col-sm-1">
                    <label for="isactive">Attiva</label>
                    <input class="form-control form-control-lg" type="checkbox" name="isactive" id="isactive" {{ $beer->isactive ? 'checked' : ''}}>
                </div>

                <div class="form-group ">
                    <div class="col-md-12">
                        @if ($beer->image)
                            <img src="{{ asset('storage/'.$beer->image) }}" style="width: 80px; height: 80px; border-radius: 50%;">
                        @endif
                        <label for="image">Immagine</label>
                        <input id="image" type="file" class="form-control" name="image" >
                    </div>
                </div>


            </div>

            <div class="form-group">
                <label for="description">Descrizione</label>
                <textarea class="form-control" name="description" id="description" rows="3">{{ $beer->description }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-2">
                    <label for="abv">ABV</label>
                    <input class="form-control" type="number" name="abv" id="abv" value="{{ $beer->abv }}"
                           step=".1" min="0">
                </div>

                <div class="form-group col-sm-2">
                    <label for="ibu">IBU</label>
                    <input class="form-control" type="number" name="ibu" id="ibu" value="{{ $beer->ibu }}"
                           step=".1" min="0">
                </div>

                <div class="form-group col-sm-2">
                    <label for="plato">Plato</label>
                    <input class="form-control" type="number" name="plato" id="plato" value="{{ $beer->plato }}"
                           step=".1" min="0">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-sm-4">
                    <label for="brewery-id">Birrificio</label>
                    <select class="form-control" name="brewery_id" id="brewery-id">
                        <option value=" ">-- seleziona un birrificio --</option>
                        @foreach($breweries as $brewery)
                            <option value="{{ $brewery->id }}" {{ $beer->brewery == $brewery ? 'selected' : '' }}>
                                {{ $brewery->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-4">
                    <label for="style-id">Stile</label>
                    <select class="form-control" name="style_id" id="style-id">
                        <option value=" ">-- seleziona uno stile --</option>
                        @foreach($styles as $style)
                            <option value="{{ $style->id }}" {{ $beer->style == $style ? 'selected' : '' }}>
                                {{ $style->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-4">
                    <label for="color-id">Colore</label>
                    <select name="color_id" id="color-id" class="form-control">
                        <option value=" ">-- seleziona un colore --</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}" {{ $beer->color == $color ? 'selected' : '' }}>
                                {{ $color->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-sm-4">
                    <label for="taste-id">Gusto Prevalente</label>
                    <select name="taste_id" id="taste-id" class="taste-control">
                        <option value=" ">-- seleziona un gusto prevalente --</option>
                        @foreach($tastes as $taste)
                            <option value="{{ $taste->id }}" {{ $beer->taste == $taste ? 'selected' : '' }}>
                                {{ $taste->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-group">
                <label for="stock">Magazzino</label>
                <input class="form-control" type="number" name="stock" id="stock" value="{{ $beer->stock }}">
            </div>

            <price-edit :packagings='@json($packagings)' :beer='@json($beer)'></price-edit>

            <button class="btn btn-primary">Aggiorna</button>
        </form>
    </div>
@endsection