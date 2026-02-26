@props(['comment', 'showButton' => true])

<div class="block bg-white overflow-hidden">
    <div class="p-8 relative">
        <div class="flex flex-col md:flex-row gap-6">
            @if($comment->images && $comment->images->isNotEmpty())
                <div class="flex-shrink-0">
                    <img src="{{ $comment->images->first()->url }}" 
                        class="w-40 h-40 object-cover rounded-lg border border-gray-100 shadow-sm"
                        alt="Comment image">
                </div>
            @endif
            <div class="flex-1">
                {{-- Header: Usuario y Trek --}}
                <div class="mb-2">
                    <h3 class="text-sm font-bold uppercase text-gray-800">
                        {{ $comment->user->name }} {{ $comment->user->lastname ?? '' }}
                    </h3>
                    <p class="text-gray-400 text-xs">
                        {{ $comment->created_at->format('d/m/Y H:i') }} | 
                        Trek: <span class="text-blue-600 font-medium">{{ $comment->meeting->trek->name ?? 'N/A' }}</span>
                    </p>
                </div>
                <div class="text-lg text-gray-700 italic mb-4 leading-relaxed">
                    "{{ $comment->comment }}"
                </div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="text-sm font-bold text-yellow-500">
                        Score: {{ $comment->score }} / 5
                    </div>
                    <div class="text-xs font-bold uppercase px-2 py-0.5 rounded {{ $comment->status === 'y' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                        {{ $comment->status === 'y' ? 'Validated' : 'Pending' }}
                    </div>
                </div>
                @if(isset($slot) && $slot->isNotEmpty())
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        {{ $slot }}
                    </div>
                @endif
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex gap-2">
                        @if($showButton)
                            <a href="{{ route('comments.show', ['comment' => $comment->id]) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded text-sm font-bold transition">
                                Show
                            </a>
                        @endif
                        @if($comment->status !== 'y')
                            <form action="{{ route('comments.validate', ['comment' => $comment->id]) }}" method="POST">
                                @csrf 
                                @method('PATCH')
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-bold transition">
                                    Validate
                                </button>
                            </form>
                        @endif
                    </div>
                    <form action="{{ route('comments.destroy', ['comment' => $comment->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar comentario e imágenes asociadas?')">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded text-sm font-bold transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>