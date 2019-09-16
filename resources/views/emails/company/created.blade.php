@component('mail::message')
# Società da verificare

L'utente {{ $company->owner->name }} ha appena creato la società {{ $company->business_name }},
dovresti valutare la società e decidere se **approvarla** o **rifiutarla**.

**Nome:** {{ $company->business_name }}<br>
**P.IVA:** {{ $company->vat_number }}<br>
**Indirizzo:** {{ $company->address }}<br>

@component('mail::button', ['url' => route('companies.show', ['company' => $company->id])])
{{ $company->business_name }}
@endcomponent
@endcomponent
