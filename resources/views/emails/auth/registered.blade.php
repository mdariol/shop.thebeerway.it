@component('mail::message')
# Nuovo utente!

Complimenti, un nuovo utente si è registrato al tuo portale!

**Nome**: {{ $user->name }}<br>
**Email**: {{ $user->email }}

@component('mail::button', ['url' => route('users.index')])
Utenti
@endcomponent
@endcomponent
