@extends('layouts.app')

@section('content')
    <div class="container">
        <h1><em>Nuova</em> Società</h1>

        <p>I dati inseriti verranno utilizzati per la fatturazione.</p>

        <form method="POST" action="{{ route('companies.store') }}">
            @csrf

            <div class="form-group">
                <label for="business-name">Ragione sociale</label>
                <input type="text" name="business_name" id="business-name" placeholder="BrewPub S.p.A." required
                       class="form-control {{ $errors->has('business_name') ? 'is-invalid' : '' }}">
                @if($errors->has('business_name'))
                    <div class="invalid-feedback">{{ $errors->first('business_name') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="vat-number">Partita IVA</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">IT</span></div>
                    <input type="text" name="vat_number" id="vat-number" required maxlength="11" pattern="[0-9]{11}"
                           class="form-control {{ $errors->has('vat_number') ? 'is-invalid' : '' }}">
                    @if($errors->has('vat_number'))
                        <div class="invalid-feedback">{{ $errors->first('vat_number') }}</div>
                    @endif
                </div>
            </div>

            <place></place>

            <div class="form-row">
                <div class="col-md-6 form-group">
                    <label for="pec">PEC <span class="text-muted">(Opzionale)</span></label>
                    <input type="email" name="pec" id="pec"
                           class="form-control {{ $errors->has('pec') ? 'is-invalid' : '' }}">
                    @if($errors->has('pec'))
                        <div class="invalid-feedback">{{ $errors->first('pec') }}</div>
                    @else
                        <small class="form-text text-muted">Indirizzo di posta elettronica certificato.</small>
                    @endif
                </div>

                <div class="col-md-6 form-group">
                    <label for="sdi">SDI <span class="text-muted">(Opzionale)</span></label>
                    <input type="text" name="sdi" id="sdi" minlength="6" maxlength="7" pattern="^[a-zA-Z0-9]*$"
                           class="form-control {{ $errors->has('sdi') ? 'is-invalid' : '' }}">
                    @if($errors->has('sdi'))
                        <div class="invalid-feedback">{{ $errors->first('sdi') }}</div>
                    @else
                        <small class="form-text text-muted">Codice del Sistema di Interscambio per la fatturazione elettronica.</small>
                    @endif
                </div>
            </div>

            <div class="form-group custom-control custom-switch">
                <input type="checkbox" name="is_default" id="is-default" class="custom-control-input"
                    {{ $company->is_default ? 'checked' : '' }}>
                <label class="custom-control-label" for="is-default">Società predefinita</label>
                <small class="form-text text-muted">Verrà utilizzata come socità di default.</small>
            </div>

            <button class="btn btn-primary">Salva</button>
            <a href="{{ back() }}" class="btn btn-link">Annulla</a>
        </form>
    </div>
@endsection
