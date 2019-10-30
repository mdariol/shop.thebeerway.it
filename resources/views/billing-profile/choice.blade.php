@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Personale o Aziendale
                    </div>
                    <div class="card-body">
                        <a href="{{ route('billing-profiles.create', ['legal_person' => true]) }}" class="btn btn-primary mr-2">Aziendale</a>
                        <a href="#" class="btn btn-primary disabled">Personale</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
