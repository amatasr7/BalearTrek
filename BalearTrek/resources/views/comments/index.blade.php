<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comment Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($comments as $comment)
                <div class="p-8 relative">
                    <div class="flex flex-col md:flex-row gap-6">
                        {{-- Imagen asociada (Picsum) --}}
                        @if($comment->images->isNotEmpty())
                            <div class="flex-shrink-0">
                                <img src="{{ $comment->images->first()->url }}" 
                                    class="w-48 h-48 object-cover rounded-lg border border-gray-200 shadow-sm"
                                    alt="Comment image">
                            </div>
                        @endif

                        <div class="flex-1">
                            <div class="mb-2">
                                <h3 class="text-sm font-bold uppercase text-gray-800">
                                    {{ $comment->user->name }} en {{ $comment->meeting->trek->name ?? 'Trek' }}
                                </h3>
                                <p class="text-gray-400 text-xs">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            {{-- Bloque de texto (Contenido del comentario) --}}
                            <div class="text-md text-gray-700 italic mb-4">
                                "{{ $comment->comment }}"
                            </div>
                            
                            <div class="text-sm font-bold text-yellow-500 mb-6">
                                Score: {{ $comment->score }} / 5
                            </div>

                            {{-- Acciones del bloque único --}}
                            <div class="flex gap-2">
                                {{-- 1. Botón Show (Ver detalle) --}}
                                <a href="{{ route('comments.show', $comment->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                                    Show
                                </a>

                                {{-- 2. Botón Validate (Solo si no está validado) --}}
                                @if($comment->status !== 'y')
                                <form action="{{ route('comments.validate', $comment->id) }}" method="POST">
                                    @csrf 
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                                        Validate
                                    </button>
                                </form>
                                @endif

                                {{-- 3. Botón Delete (Posicionamiento absoluto esquina inferior derecha) --}}
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment and its associated images?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm font-bold transition absolute bottom-8 right-8">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Paginación --}}
            <div class="mt-8">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>