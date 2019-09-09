@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3">{{ $user->name }}</h1>

        <dl class="row">
            <dt class="col-md-2">Nome</dt><dd class="col-md-10">{{ $user->name }}</dd>
            <dt class="col-md-2">E-mail</dt><dd class="col-md-10">{{ $user->email }}</dd>
            <dt class="col-md-2">Password</dt><dd class="col-md-10">*******</dd>
            <dt class="col-md-2">Iscritto</dt><dd class="col-md-10">{{ $user->created_at }}</dd>
        </dl>

        <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-primary mb-5">Modifica</a>

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
