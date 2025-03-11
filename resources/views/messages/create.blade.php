@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Iniciar una nueva conversación</h1>

    <form action="{{ route('messages.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user2_id">Selecciona un usuario:</label>
            <select name="user2_id" id="user2_id" class="form-control" required>
                <option value="">Seleccione un usuario</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Iniciar conversación</button>
    </form>
</div>
@endsection
