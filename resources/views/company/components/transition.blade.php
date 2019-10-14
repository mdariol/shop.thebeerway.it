@php
$color = 'primary';
$icon = 'question';

if ($company->is_approved) {
    $color = 'success';
    $icon = 'check';
}

if ($company->is_rejected) {
    $color = 'danger';
    $icon = 'times';
}
@endphp

<div class="card mb-3 {{ "border-$color" }}" style="max-width: 18rem;">
    <div class="card-body {{ "text-$color" }}">
        <h3 class="card-title"><span class="far {{ "fa-$icon-circle" }}"></span> {{ ucfirst(__("states.$company->state")) }}</h3>

        @if($company->is_approved)
            <p>Questa società è stata approvata. Hai cambiato idea?</p>
        @elseif($company->is_rejected)
            <p>Questa società è stata rifiutata. Hai cambiato idea?</p>
        @else
            <p>Questa società deve essere verificata. Cosa vuoi fare?</p>
        @endif

        <form method="POST" action="{{ route('companies.transition', ['company' => $company->id]) }}">
            @csrf
            @method('PATCH')

            @foreach($company->state_machine->getPossibleTransitions() as $transition)
                    <button class="btn {{ $loop->first ? "btn-$color" : 'btn-link' }}" name="transition"
                            value="{{ $transition }}">{{ ucfirst(__("states.$transition")) }}</button>
            @endforeach
        </form>
    </div>
</div>
