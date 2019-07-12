@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Elimina <em>{{ $beer->name }}</em></h1>


        <form method="POST" action="{{str_replace('/delete', '', request()->getRequestUri() )}}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-primary">Delete</button>
            <a href="{{str_replace('/'.$beer->id.'/delete?','?',request()->getRequestUri())}}">Cancel</a>

        </form>
    </div>
@endsection