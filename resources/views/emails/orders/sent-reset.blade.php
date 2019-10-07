@component('mail::message')
# Richiesta d'ordine Inviata

La tua richiesta d'ordine **{{ $order->number }}/{{ $order->id }}** del **{{ $order->date }}** è stata inviata riaperta. Puoi apportare le modifiche che desideri per poi inviarcela nuovamente.

##Questo è il riepilogo attuale della tua richiesta
| Descrizione      | Imponibile   |
| :--              | --:          |
    @foreach ($order->lines as $line)
        | {{ $line->beer->name}} - {{ $line->beer->packaging->name }} x {{ $line->qty}} | {{ $line->price}}   |
    @endforeach
| **Totale** | **{{ $order->total_amount }}** |
<br>

## Merce da spedire a:
> {{ $order->shipping_address->name }}
> {{ $order->shipping_address->postal_code }} - {{ $order->shipping_address->route  }}

## Note di spedizione:
> {{ $order->deliverynote  }}

Grazie,<br>
{{ config('app.name') }}
@endcomponent
