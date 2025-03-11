<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Listar conversaciones
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $conversations = $user->conversations()
            ->with([
                'user1', 
                'user2',
                'messages' => function($query) {
                    $query->latest()->limit(1);
                }
            ])
            ->when($request->has('search'), function($query) use ($request) {
                return $query->whereHas('user1', function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%");
                })->orWhereHas('user2', function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%");
                });
            })
            ->paginate(10);
    
        return view('messages.index', compact('conversations'));
    }
    
    // Mostrar conversación
    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);
        
        $messages = $conversation->messages()
            ->with(['sender', 'receiver'])
            ->latest()
            ->paginate(20);

        return view('messages.show', [
            'conversation' => $conversation,
            'messages' => $messages
        ]);
    }

    // Enviar mensaje
    public function store(Request $request, Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        $request->validate([
            'body' => 'required|string|max:2000'
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'receiver_id' => $conversation->user1_id == Auth::id() 
                ? $conversation->user2_id 
                : $conversation->user1_id,
            'body' => $request->body
        ]);

        // Marcar como no leído
        $message->update(['read_at' => null]);

        return redirect()->back();
    }

    // Iniciar nueva conversación
    public function start(User $user)
    {
        if (Auth::id() == $user->id) {
            abort(403, 'No puedes enviarte mensajes a ti mismo');
        }

        $conversation = Conversation::firstOrCreate([
            'user1_id' => Auth::id(),
            'user2_id' => $user->id
        ]);

        return redirect()->route('messages.show', $conversation);
    }

    // Función adicional: Marcar como leído
    public function markAsRead(Message $message)
    {
        if ($message->receiver_id == Auth::id()) {
            $message->update(['read_at' => now()]);
            return response()->json(['success' => true]);
        }
        
        abort(403);
    }
}