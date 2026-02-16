<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Comment Detail') }} #{{ $comment->id }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 relative">
                    <div class="flex flex-col md:flex-row gap-6">
                        
                        @if($comment->images->isNotEmpty())
                            <div class="flex-shrink-0">
                                <img src="{{ $comment->images->first()->url }}" 
                                    class="w-64 h-64 object-cover rounded-lg border border-gray-200 shadow-sm"
                                    alt="Comment image"
                                    onerror="this.onerror=null;this.src='https://via.placeholder.com/600x400?text=No+Image+Available';">
                            </div>
                        @endif

                        <div class="flex-1">
                            <div class="mb-4">
                                <h3 class="text-lg font-bold uppercase text-gray-800">
                                    {{ $comment->user->name }}
                                </h3>
                                <p class="text-gray-500 text-sm">
                                    Posted on: {{ $comment->created_at->format('d/m/Y H:i') }}
                                </p>
                                <p class="text-black-600 font-medium">
                                    Trek: {{ $comment->meeting->trek->name ?? 'N/A' }}
                                </p>
                            </div>

                            {{-- Contenido del comentario --}}
                            <div class="text-xl text-gray-700 italic mb-6 leading-relaxed">
                                "{{ $comment->comment }}"
                            </div>
                            
                            <div class="text-lg font-bold text-black-500 mb-8">
                                Score: {{ $comment->score }} / 5
                            </div>

                            <div class="flex gap-4">
                                {{-- Botón Validate --}}
                                @if($comment->status !== 'y')
                                <form action="{{ route('comments.validate', $comment->id) }}" method="POST">
                                    @csrf 
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-bold transition shadow-sm">
                                        Validate
                                    </button>
                                </form>
                                @endif

                                {{-- Botón Delete --}}
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded font-bold transition shadow-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>