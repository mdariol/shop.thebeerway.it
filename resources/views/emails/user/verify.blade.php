@component('mail::message')
# Ciao {{ $user->name }}!

Per completare la registrazione verifica il tuo indirizzo e-mail cliccando sul bottone sottostante.

@component('mail::button', ['url' => $url])
Verifica indirizzo e-mail
@endcomponent

Ricevi questa notifica perché la tua e-mail è stata utilizzata per iscriverti al nostro sito.

Grazie,<br>
{{ config('app.name') }}
@endcomponent
