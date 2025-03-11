@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Mis Conversaciones</h1>

    <!-- Barra de búsqueda -->
    <form method="GET" action="{{ route('messages.index') }}" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Buscar conversación..." value="{{ request('search') }}">
    </form>

    @if($conversations->count() > 0)
        <div class="list-group">
            @foreach ($conversations as $conversation)
                @php
                    $otherUser = $conversation->user1_id == auth()->id() ? $conversation->user2 : $conversation->user1;
                    $lastMessage = $conversation->messages->first();
                @endphp
                <a href="{{ route('messages.show', $conversation) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ $otherUser->name }}</strong>
                            <p class="mb-1 text-muted">
                                {{ $lastMessage ? Str::limit($lastMessage->body, 50) : 'No hay mensajes aún' }}
                            </p>
                        </div>
                        <small class="text-muted">
                            {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : '' }}
                        </small>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-3">
            {{ $conversations->links() }}
        </div>
    @else
        <p class="text-muted">No tienes conversaciones.</p>
    @endif
</div>
@endsection
