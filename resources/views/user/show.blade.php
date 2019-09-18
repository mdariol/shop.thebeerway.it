@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-md-flex mb-5">
            <div style="width: 10rem; height: 10rem; border-radius: 50%; background-image: url({{ "/storage/$user->profile_image" }}); background-color: rgba(0, 0, 0, 0.03); background-size: cover;"
                 class="mx-auto mx-md-0 mr-md-3 mb-3 mb-md-0"></div>

            <div class="flex-grow-1 align-self-center text-center text-md-left">
                <h1>{{ $user->name }}</h1>
                <p>{{ $user->email }}</p>

                <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary">Modifica</a>
            </div>
        </div>

        <section>
            <h2>Le tue società</h2>
            <div class="d-flex overflow-auto">
                @foreach($user->companies as $company)
                    <div class="card mr-3 flex-shrink-0" style="width: 19rem;">
                        <div class="card-body">
                            <form action="{{ route('companies.default', ['company' => $company->id]) }}"
                                  method="POST" class="float-right">
                                @csrf
                                @method('PATCH')

                                <label class="{{ $company->is_default ? 'fas' : 'far' }} fa-star" style="cursor: pointer;"
                                       for="is-default-{{ $company->id }}"></label>
                                <input type="checkbox" name="is_default" id="is-default-{{ $company->id }}"
                                       class="d-none" onchange="this.form.submit()">
                            </form>
                            <h4 class="card-title text-truncate mr-4">
                                <a href="{{ route('companies.show', ['id' => $company->id]) }}">{{ $company->business_name }}</a>
                            </h4>
                            <hr>
                            <small class="text-muted">IT-{{ $company->vat_number }}</small>
                            <p class="mb-0">{{ $company->address }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('companies.edit', ['company' => $company->id]) }}" class="card-link">Modifica</a>
                        </div>
                    </div>
                @endforeach

                <div class="card flex-shrink-0" style="width: 19rem; border-style: dashed">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <h3 class="card-title text-center mb-4">Aggiungi una nuova Società</h3>
                        <a href="{{ route('companies.create') }}" class="btn btn-primary">Aggiungi</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
