@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuova Policy</h1>

        <form method="POST" action="/policies">
            @csrf

            <div class="form-group">
                <label for="name">Nome</label>
                <select class="form-control" name="name" id="name">
                    <option label=" ">-- Seleziona un'opzione --</option>
                    @foreach(\App\Policy::POLICYNAME as $name)
                        <option value="{{ $name }}">
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="content">Contenuto</label>
                <textarea class="w-100" name="content" id="content" rows="20"></textarea>
            </div>
            <div class="form-group">
                <label for="from_date">dall data</label>
                <input type="date" name="from_date" id="from_date">
            </div>

            <button class="btn btn-primary">Memorizza</button>
        </form>
    </div>
@endsection