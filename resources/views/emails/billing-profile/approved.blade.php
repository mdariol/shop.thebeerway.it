@component('mail::message')
# Società riconosciuta!

Congratulazioni, la società **{{ $billingProfile->name }}** è stata
riconosciuta dal nostro staff! Ora sarai in grado di visualizzare **prezzi** e
**disponibilità** sul nostro portale.

Cosa stai aspettando?! Corri a vedere le nostre ultime novità.

@component('mail::button', ['url' => route('beers.index')])
{{ config('app.name') }}
@endcomponent
@endcomponent
