<div class="space-y-4">
    @foreach($conversations as $conversation)
    <a href="{{ route('messages.show', $conversation) }}" 
       class="block p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-4">
            <img src="{{ $conversation->otherUser->profile_photo_url }}" 
                 class="w-12 h-12 rounded-full" 
                 alt="{{ $conversation->otherUser->name }}">
            <div>
                <h4 class="font-semibold">{{ $conversation->otherUser->name }}</h4>
                <p class="text-gray-600 text-sm">
                    {{ optional($conversation->messages->last())->body ?? 'Nueva conversación' }}
                </p>
            </div>
        </div>
    </a>
    @endforeach
</div>