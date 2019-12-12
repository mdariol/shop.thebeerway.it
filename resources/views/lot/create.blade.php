@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuovo</em> Lotto</h1>

        <form method="POST" action="{{ route('admin.lots.store') }}">
            @csrf

            <div class="form-group">
                <label for="number">Num. Lotto</label>
                <input type="text" name="number" id="number" value="{{ old('number') }}"
                       class="form-control @error('number') is-invalid @enderror">
                @error('number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @else
                    <small class="form-text text-muted">Identificativo univoco del lotto.</small>
                @enderror
            </div>

            <input-autocomplete :route='@json(route('beers.index'))' :label='@json('Birra')' :name='@json('beer_id')'
                                :description='@json('La birra associata a questo lotto.')'
                                @error('beer_id') :error='@json($message)' @enderror>
                <template v-slot:option="{option}">
                    @{{ option.name }} <span class="ml-1 text-muted">@{{ option.brewery.name }}</span> <br>
                    <small>@{{ option.packaging.name }}</small>
                </template>
            </input-autocomplete>

            <div class="form-row">
                <div class="form-group col-md">
                    <label for="stock">Magazzino</label>
                    <input class="form-control @error('stock') is-invalid @enderror"
                           type="number" name="stock" id="stock" min="0" value="{{ old('stock') ?? 0 }}">
                    @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <small class="form-text text-muted">Numero di elementi a magazzino.</small>
                        @enderror
                </div>

                <div class="form-group col-md">
                    <label for="reserved">Ordinato</label>
                    <input class="form-control @error('reserved') is-invalid @enderror"
                           type="number" name="reserved" id="reserved" min="0" value="{{ old('reserved') ?? 0 }}">
                    @error('reserved')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <small class="form-text text-muted">Numero di elementi ordinati.</small>
                        @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label for="bottled-at">Imbottigliata</label>
                    <input class="form-control @error('bottled_at') is-invalid @enderror"
                           type="date" name="bottled_at" id="bottled-at" >
                    @error('bottled_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <small class="form-text text-muted">Data di imbottigliamento.</small>
                        @enderror
                </div>

                <div class="form-group col-md">
                    <label for="expires-at">Scadenza</label>
                    <input class="form-control @error('expires_at') is-invalid @enderror"
                           type="date" name="expires_at" id="expires-at">
                    @error('expires_at')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <small class="form-text text-muted">Data di scadenza.</small>
                        @enderror
                </div>
            </div>

            <button class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection
