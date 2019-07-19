@component('mail::message')
# Richiesta di approvazione

Caro amministratore, l'utente {{ $user->name }} di {{ $user->horecaname }} chiede di essere eletto al ruolo di Publican.

@component('mail::button', ['url' => $url])
Utenti
@endcomponent

Grazie,<br>
{{ config('app.name') }}
@endcomponent
