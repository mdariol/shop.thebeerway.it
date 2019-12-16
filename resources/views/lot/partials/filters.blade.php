<div class="card bg-light mb-4">
    <div class="card-header">
        <a href="#filters" class="d-block text-secondary" data-toggle="collapse">Filtri</a>
    </div>
    <div class="card-body collapse" id="filters">
        <form class="mb-0" action="{{ route('admin.lots.index') }}">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="name">Numero</label>
                    <input type="text" name="number" id="number" class="form-control" value="{{ request()->number }}">
                    <small class="text-form text-muted">Codice identificativo del lotto.</small>
                </div>

                <div class="form-group col-md-4">
                    <label for="available">Disponibilità</label>
                    <input type="number" name="available" id="available" min="1" class="form-control"
                           value="{{ request()->available }}">
                    <small class="text-form text-muted">Disponibilità inferiore a...</small>
                </div>

                <div class="form-group col-md-4">
                    <label for="expires-at">Scadenza</label>
                    <input type="date" name="expires_at" id="expires-at" class="form-control"
                           value="{{ request()->expires_at }}">
                    <small class="text-muted text-form">Scadono prima della data...</small>
                </div>

                <input-autocomplete class="col-md-6" :route='@json(route('beers.index'))' :name='@json('name')'
                                    :label='@json('Birra')' :multiple='@json(true)'>
                    <template v-slot:option="{option}">
                        @{{ option.name }} <span class="ml-1 text-muted">@{{ option.brewery.name }}</span> <br>
                        <small>@{{ option.packaging.name }}</small>
                    </template>
                </input-autocomplete>

                <input-autocomplete class="col-md-6" :route='@json(route('breweries.index'))' :name='@json('brewery')'
                                    :label='@json('Birrificio')' :multiple='@json(true)'></input-autocomplete>
            </div>

            <button class="btn btn-primary">Filtra</button>
            <a href="{{ route('admin.lots.index') }}" class="btn btn-link">Reset</a>
        </form>
    </div>
</div>
