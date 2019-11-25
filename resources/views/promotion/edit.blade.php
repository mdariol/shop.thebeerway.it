@extends('layouts.app')

@section('content')



    <div class="container">


        <h1>Modifica Promozione <em>{{ $promotion->name }} - {{ $promotion->from_date }} - {{ $promotion->to_date }} </em> </h1>

        <form method="POST" action="/promotions/{{ $promotion->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" value="{{ $promotion->name }}"></text>
            </div>

            <div class="form-group">
                <label for="discount">Sconto</label>
                <input type="number" name="discount" id="discount" min="0" max="100" step=".50" value="{{ $promotion->discount }}">
            </div>

            <div class="form-group">
                <label for="from_date">dalla data</label>
                <input type="date" name="from_date" id="from_date" value="{{ $promotion->from_date }}">
            </div>

            <div class="form-group">
                <label for="to_date">alla data</label>
                <input type="date" name="to_date" id="to_date" value="{{ $promotion->to_date }}">
            </div>

            <div class="form-group">
                <label for="priority">priorità</label>
                <input type="number" name="priority" id="priority" value="{{ $promotion->priority }}">
            </div>


            <div class="form-group">
                <span>Birre in promozione</span>
                <input-autocomplete :route="'/beers'" :search-by="'name'" :name="'beers'" :multiple="true"
                                    :default="{{json_encode($promotion->beers)}}"
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
                                    :default="{{json_encode($promotion->breweries)}}"
                                    :description="'Seleziona i birrifici che vuoi aggiungere.'" >
                    <template v-slot:option="{option}">
                        <span> @{{ option.name }}</span>
                    </template>
                </input-autocomplete>
            </div>

            <div class="form-group">
                <span>Utenti in promozione</span>
                <input-autocomplete :route="'/users'" :search-by="'email'" :name="'users'" :multiple="true"
                                    :default="{{json_encode($promotion->users)}}"
                                    :description="'Seleziona gli utenti via email che vuoi aggiungere.'" >
                    <template v-slot:option="{option}">
                        <span> @{{ option.name }} - @{{ option.email }}</span>
                    </template>
                    <template v-slot:tag="{tag}">
                        <span>@{{ tag.name }} - @{{ tag.email }}</span>
                    </template>
                </input-autocomplete>
            </div>

            <button class="btn btn-primary">Aggiorna</button>
        </form>
    </div>

@endsection