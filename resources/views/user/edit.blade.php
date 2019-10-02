@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-3"><em>Modifica</em> {{$user->email}}</h1>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Modifica le Info</h5>
                    <hr>

                    <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" required
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <input-image :name='@json('profile_image')' :label='@json('Immagine del Profilo')'
                                     @if($user->profile_image) :default='@json(asset("storage/$user->profile_image"))' @endif
                                     @error('profile_image') :error='@json($message)' @enderror></input-image>

                        <div class="form-group custom-control custom-switch">
                            <input type="checkbox" name="is_horeca" id="is-horeca" class="custom-control-input"
                                {{ $user->is_horeca ? 'checked' : '' }}>
                            <label for="is-horeca" class="custom-control-label">Ho.Re.Ca</label>
                            <small class="form-text text-muted">Possiedo un'attività commerciale.</small>
                        </div>

                        <button class="btn btn-primary">Salva</button>
                        <a href="{{ route('users.delete', ['user' => $user->id]) }}" class="btn btn-link">Elimina</a>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cambia la Password</h5>
                    <hr>

                    <form method="POST" action="{{ route('users.password', ['user' => $user->id]) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="current-password">Password attuale</label>
                            <input type="password" name="current_password" id="current-password" required
                                   class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @else
                                <small class="form-text text-muted">Inserisci la tua password attuale.</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" required
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @else
                                <small class="form-text text-muted">Inserisci la nuova password.</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirmation">Conferma Password</label>
                            <input type="password" name="password_confirmation" id="password-confirmation" required
                                   class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @else
                                <small class="form-text text-muted">Inserisci nuovamente la tua password.</small>
                            @enderror
                        </div>

                        <button class="btn btn-primary">Cambia</button>
                    </form>
                </div>
            </div>
    </div>
@endsection
<script>
    import InputImage from "../../js/components/InputImage";
    export default {
        components: {InputImage}
    }
</script>
