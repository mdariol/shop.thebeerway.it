@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuova Promozione</h1>

        <form method="POST" action="/promotions">
            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" ></input>
            </div>

            <div class="form-group">
                <label for="discount">Sconto</label>
                <input type="number" name="discount" id="discount" min="0" max="100" step="0.50">
            </div>
            <div class="form-group">
                <label for="from_date">dalla data</label>
                <input type="date" name="from_date" id="from_date">
            </div>
            <div class="form-group">
                <label for="to_date">alla data</label>
                <input type="date" name="to_date" id="to_date">
            </div>
            <div class="form-group">
                <label for="priority">Priorità</label>
                <input type="number" name="priority" id="priority" value="0">
            </div>

            <div class="form-group">
                <span>Birre in promozione</span>
                <input-autocomplete :route="'/beers'" :search-by="'name'" :name="'beers'" :multiple="true"
                                    :description="'Seleziona le birre che vuoi aggiungere.'" >
                    <template v-slot:option="{option}">
                        <span>
                            @{{ option.name }} <span class="ml-1 text-muted">@{{ option.brewery.name }}</span> <br>
                            <small>@{{ option.packaging.name }} </small>
                        </span>
                    </template>
                    <template v-slot:tag="{tag}">
                        <span>
                            @{{ tag.name }} <span class="ml-1 text-muted">@{{ tag.brewery.name }}</span> <br>
                            <small>@{{ tag.packaging.name }} </small>
                        </span>
                    </template>
                </input-autocomplete>
            </div>

            <div class="form-group">
                <span>Birrifici in promozione</span>
                <input-autocomplete :route="'/breweries'" :search-by="'name'" :name="'breweries'" :multiple="true"
                                    :description="'Seleziona i birrifici che vuoi aggiungere.'" >
                    <template v-slot:option="{option}">
                        <span> @{{ option.name }}</span>
                    </template>
                </input-autocomplete>
            </div>

            <div class="form-group">
                <span>Utenti in promozione</span>
                <input-autocomplete :route="'/users'" :search-by="'email'" :name="'users'" :multiple="true"
                                    :description="'Seleziona gli utenti via email che vuoi aggiungere.'" >
                    <template v-slot:option="{option}">
                        <span> @{{ option.name }} - @{{ option.email }}</span>
                    </template>
                    <template v-slot:tag="{tag}">
                        <span>@{{ tag.name }} - @{{ tag.email }}</span>
                    </template>
                </input-autocomplete>
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>




    </div>
@endsection