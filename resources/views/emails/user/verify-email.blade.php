@component('mail::message')
# Ciao {{ $user->name }}!

Benvenuto sul nostro portale! Per completare la registrazione verifica il tuo indirizzo
email cliccando sul bottone sottostante.

@component('mail::button', ['url' => $url])
Verifica indirizzo
@endcomponent

Grazie,<br>
{{ config('app.name') }} Staff.
@endcomponent
