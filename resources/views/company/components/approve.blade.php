<div class="card border-{{ $state->color }} mb-3" style="max-width: 18rem;">
    <div class="card-body text-{{ $state->color }}">
        <h3 class="card-title"><span class="far {{ $state->icon }}"></span> {{ $state->title }}</h3>

        <p>{{ $state->text }}</p>

        <form method="POST" action="{{ route('companies.approve', ['company' => $company->id]) }}">
            @csrf
            @method('PATCH')

            @foreach($company->state_machine->getPossibleTransitions() as $transition)
                <div class="form-check form-check-inline">
                    <input type="radio" name="transition" id="transition-{{ $transition }}" value="{{ $transition }}"
                           class="form-check-input d-none" onchange="this.form.submit()">
                    <label class="form-check-label btn {{ $loop->first ? $state->button : 'btn-link' }}" style="cursor: pointer;"
                           for="transition-{{ $transition }}">{{ $transition === 'approve' ? 'Approva' : 'Rifiuta' }}</label>
                </div>
            @endforeach
        </form>
    </div>
</div>
