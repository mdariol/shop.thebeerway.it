@component('mail::message')
# Società riconosciuta!

Congratulazioni, la società **{{ $company->business_name }}** è stata
riconosciuta dal nostro staff! Ora sarai in grado di visualizzare **prezzi** e
**disponibilità** sul nostro portale.

Cosa stai aspettando?! Corri a vedere le nostre ultime novità.

@component('mail::button', ['url' => route('beers.index')])
{{ config('app.name') }}
@endcomponent
@endcomponent
