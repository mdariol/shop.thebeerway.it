@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuova</em> Società</h1>

        <p>I dati inseriti verranno utilizzati per la fatturazione.</p>

        <form method="POST" action="/companies">
            @csrf

            <div class="form-group">
                <label for="business-name">Ragione sociale</label>
                <input type="text" name="business_name" id="business-name" class="form-control"
                       placeholder="BrewPub S.p.A." required>
            </div>

            <div class="form-group">
                <label for="vat-number">Partita IVA</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">IT</span></div>
                    <input type="text" name="vat_number" id="vat-number" class="form-control" required
                           maxlength="11" pattern="^[0-9]*$">
                </div>
            </div>

            <place></place>

            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label for="pec">PEC</label>
                    <input type="email" name="pec" id="pec" class="form-control">
                    <small class="form-text text-muted">Indirizzo di posta elettronica certificato.</small>
                </div>

                <div class="col-md-6 form-group">
                    <label for="sdi">SDI</label>
                    <input type="text" name="sdi" id="sdi" class="form-control" minlength="6"
                           maxlength="7" pattern="^[a-zA-Z0-9]*$">
                    <small class="form-text text-muted">Codice del Sistema di Interscambio per la fatturazione elettronica.</small>
                </div>
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ route('companies.index') }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
