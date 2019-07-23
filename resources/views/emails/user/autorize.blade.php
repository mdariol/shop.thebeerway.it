@component('mail::message')
# Ciao {{ $user->name }}!

Il nostro staff ha ti ha abilitato a vedere disponibilità e prezzi del nostro portale.

Contattaci per ordinare.

Ricevi questa notifica perché la tua e-mail è stata utilizzata per iscriverti al nostro sito.

Grazie,<br>
{{ config('app.name') }}
@endcomponent
