@component('mail::message')
# Società da verificare

L'utente {{ $billingProfile->owner->name }} ha appena creato la società {{ $billingProfile->name }},
dovresti valutare la società e decidere se **approvarla** o **rifiutarla**.

**Nome:** {{ $billingProfile->business_name }}<br>
**P.IVA:** {{ $billingProfile->vat_number }}<br>
**Indirizzo:** {{ $billingProfile->address }}<br>

@component('mail::button', ['url' => route('billing-profiles.show', ['billing_profile' => $billingProfile->id])])
{{ $billingProfile->name }}
@endcomponent
@endcomponent
