<?php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Models\User; // Esto es necesario para usar el modelo User en el controlador

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
    
        // Obtener todas las conversaciones del usuario
        $conversations = Conversation::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
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
    
public function createForm()
{
    // Obtener todos los usuarios para que el usuario pueda elegir
    $users = User::all();

    // Mostrar el formulario para crear la conversación
    return view('messages.create', compact('users'));
}

public function create(Request $request)
{
    $user = Auth::user();

    // Validar que se pasen los usuarios involucrados en la conversación
    $request->validate([
        'user2_id' => 'required|exists:users,id|different:user1_id',
    ]);

    // Crear una nueva conversación
    $conversation = Conversation::create([
        'user1_id' => $user->id,
        'user2_id' => $request->user2_id,
    ]);

    // Crear el primer mensaje
Message::create([
    'conversation_id' => $conversation->id,
    'user_id' => $user->id,  // Asignar el ID del usuario
    'body' => '¡Hola! Esta es nuestra primera conversación.',
]);


    // Redirigir a la vista de la conversación
    return redirect()->route('messages.show', $conversation->id);
}
public function show($conversationId)
{
    $conversation = Conversation::with(['user1', 'user2', 'messages.user'])->findOrFail($conversationId);
    return view('messages.show', compact('conversation'));
}

}
