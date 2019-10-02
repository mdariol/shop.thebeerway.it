@extends('layouts.app')

@section('content')



    <div class="container">


        <h1>Modifica Policy <em>{{ $policy->name }} - {{ $policy->from_date }}</em> </h1>


        <form method="POST" action="/policies/{{ $policy->id }}">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="name">Nome</label>
                <select class="form-control" name="name" id="name">
                    <option label=" ">-- Seleziona un'opzione --</option>
                    @foreach(\App\Policy::POLICYNAME as $name)
                        <option {{ $policy->name == $name ? 'selected' : '' }} value="{{ $name }}">
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="content">Contenuto</label>
                <textarea class="w-100" name="content" id="content" rows="20">{{ $policy->content }}</textarea>
            </div>
            <div class="form-group">
                <label for="from_date">dalla data</label>
                <input type="date" name="from_date" id="from_date" value="{{ $policy->from_date }}">
            </div>

            <button class="btn btn-primary">Aggiorna</button>
        </form>
    </div>

@endsection