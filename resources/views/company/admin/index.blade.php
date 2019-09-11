@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Società</h1>

        <p>Elenco delle società.</p>

        @if( ! $companies->count())
            <p class="text-muted">Non c'è alcuna società...</p>
        @endif

        <div class="table-responsive mt-5">
            <table class="table">
                <thead>
                <tr>
                    <th class="d-none d-md-table-cell">#</th>
                    <th>Nome</th>
                    <th class="d-none d-md-table-cell">Proprietario</th>
                    <th class="d-none d-md-table-cell">Indirizzo</th>
                    <th>Stato</th>
                    <th>Operazioni</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td class="d-none d-md-table-cell align-middle">{{ $company->id }}</td>
                        <td class="align-middle align-middle">{{ $company->business_name }}</td>
                        <td class="d-none d-md-table-cell align-middle">{{ $company->owner->name }}</td>
                        <td class="d-none d-md-table-cell align-middle">{{ $company->address }}</td>
                        @if($company->is_pending)
                            <td class="align-middle"><span class="far fa-question-circle text-info" style="font-size: 1.5rem;"></span></td>
                        @elseif($company->is_approved)
                            <td class="align-middle"><span class="far fa-check-circle text-success" style="font-size: 1.5rem;"></span></td>
                        @else
                            <td class="align-middle"><span class="far fa-times-circle text-danger" style="font-size: 1.5rem;"></span></td>
                        @endif
                        <td class="align-middle">
                            <a href="{{ route('companies.edit', ['id' => $company->id]) }}"
                               class="btn btn-primary">Modifica</a>
                            <a href="{{ route('companies.delete', ['company' => $company->id]) }}"
                               class="btn btn-link">Elimina</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

