@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Modifica</em> Profilo di Fatturazione</h1>

        <form method="POST" action="/companies/{{ $company->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="business-name">Ragione sociale</label>
                <input type="text" name="business_name" id="business-name" class="form-control"
                       placeholder="BrewPub S.p.A." required value="{{ $company->business_name }}">
            </div>

            <div class="form-group">
                <label for="vat-number">Partita IVA</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">IT</span></div>
                    <input type="text" name="vat_number" id="vat-number" class="form-control" required value="{{ $company->vat_number }}">
                </div>
            </div>

            <place :value='@json($company->address)'></place>

            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label for="pec">PEC</label>
                    <input type="email" name="pec" id="pec" class="form-control" value="{{ $company->pec }}">
                    <small class="form-text text-muted">Indirizzo di posta elettronica certificato.</small>
                </div>

                <div class="col-md-6 form-group">
                    <label for="sdi">SDI</label>
                    <input type="text" name="sdi" id="sdi" class="form-control" value="{{ $company->sdi }}"
                           minlength="6" maxlength="7" pattern="^[a-zA-Z0-9]*$">
                    <small class="form-text text-muted">Codice del Sistema di Interscambio per la fatturazione elettronica.</small>
                </div>
            </div>

            <button class="btn btn-primary">Salva</button>
        </form>
    </div>
@endsection
