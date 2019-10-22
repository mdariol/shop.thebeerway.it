@component('mail::message')
# Richiesta d'ordine Inviata

La tua richiesta d'ordine **{{ $order->number }}/{{ $order->id }}** del **{{ $order->date }}** è stata inviata al nostro staff che ti invierà conferma d'ordine appena possibile.

##Questo è il riepilogo della tua richiesta
| Descrizione      | Imponibile   |
| :--              | --:          |
    @foreach ($order->lines as $line)
        | <a href="{{ route('download', ['file' => $line->beer->image]) }}">{{ $line->beer->name }}</a> - {{ $line->beer->packaging->name }} x {{ $line->qty}} | {{ $line->price}}   |
        | <a href="{{ route('download', ['file' => $line->beer->brewery->logo]) }}">{{ $line->beer->brewery->name }}</a> | |
    @endforeach
| **Totale** | **{{ $order->total_amount }}** |
<br>


*Cliccare sul nome della birra per scaricare il bollo spina o l'etichetta*
*Cliccare sul nome del birrificio per scaricare il logo del birrificio*


## Spedire a:
> {{ $order->shipping_address->name }}
> {{ $order->shipping_address->postal_code }} - {{ $order->shipping_address->route  }}

## Fatturare a:
> {{ $order->billing_profile->name }}
> {{ $order->billing_profile->postal_code }} - {{ $order->billing_profile->route  }}

@if ($order->deliverynote)
## Note di spedizione:
> {{ $order->deliverynote  }}
@endif

Grazie,<br>
{{ config('app.name') }}
@endcomponent


