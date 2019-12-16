<div class="card bg-light mb-4">
    <div class="card-header">
        <a href="#filters" class="d-block text-secondary" data-toggle="collapse">Filtri</a>
    </div>
    <div class="card-body collapse" id="filters">
        <form class="mb-0" action="{{ route('admin.lots.index') }}">
            <div class="form-row">
                <div class="form-group col-md-6 col-lg">
                    <label for="name">Numero</label>
                    <input type="text" name="number" id="number" class="form-control" value="{{ request()->number }}">
                    <small class="text-form text-muted">Codice identificativo del lotto.</small>
                </div>

                <input-autocomplete class="col-md-6 col-lg" :route='@json(route('beers.index'))' :name='@json('name')'
                                    :label='@json('Birra')' :multiple='@json(true)'>
                    <template v-slot:option="{option}">
                        @{{ option.name }} <span class="ml-1 text-muted">@{{ option.brewery.name }}</span> <br>
                        <small>@{{ option.packaging.name }}</small>
                    </template>
                </input-autocomplete>

                <input-autocomplete class="col-md-6 col-lg" :route='@json(route('breweries.index'))' :name='@json('brewery')'
                                    :label='@json('Birrificio')' :multiple='@json(true)'></input-autocomplete>

                <div class="form-group col-md-6 col-lg">
                    <label for="expiring_at">Scadenza</label>
                    <input type="date" name="expiring_at" id="expiring-at" class="form-control" value="{{ request()->expiring }}">
                    <small class="text-muted text-form">Scadono prima della data...</small>
                </div>
            </div>

            <button class="btn btn-primary">Filtra</button>
            <a href="{{ route('admin.billing-profiles.index') }}" class="btn btn-link">Reset</a>
        </form>
    </div>
</div>
