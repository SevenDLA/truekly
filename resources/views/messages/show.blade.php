@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Conversación con {{ $conversation->user1_id == auth()->id() ? $conversation->user2->name : $conversation->user1->name }}</h1>

    <div class="list-group">
        @foreach ($conversation->messages as $message)
            <div class="list-group-item">
                <strong>{{ $message->user->name }}:</strong> {{ $message->body }}
            </div>
        @endforeach
    </div>

    <form action="{{ route('messages.storeMessage', $conversation->id) }}" method="POST">
        @csrf
        <textarea name="body" class="form-control mt-3" placeholder="Escribe tu mensaje..."></textarea>
        <button type="submit" class="btn btn-primary mt-2">Enviar</button>
    </form>
</div>
@endsection
