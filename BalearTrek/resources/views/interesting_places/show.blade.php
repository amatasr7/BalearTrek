<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Show Interesting Place') }} : {{ $interestingPlace->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 relative">
                
                <div class="mb-6">
                    <h3 class="text-2xl font-bold uppercase text-gray-700">{{ $interestingPlace->name }}</h3>
                    <p class="text-lg text-blue-600 font-semibold">{{ $interestingPlace->placeType->name ?? 'Sense tipus' }}</p>
                </div>

                <div class="text-sm text-gray-600 space-y-2 mb-8">
                    <p><span class="font-bold text-gray-700">GPS Location:</span> {{ $interestingPlace->gps }}</p>
                    <p><span class="font-bold text-xs uppercase text-green-600">Published: Yes</span></p>
                    
                    <div class="mt-6 pt-6 border-t border-gray-100 text-xs text-gray-400">
                        <p><span class="uppercase">Creat el:</span> {{ $interestingPlace->created_at->format('d/m/Y H:i') }}</p>
                        <p><span class="uppercase">Última actualització:</span> {{ $interestingPlace->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('interesting-places.edit', $interestingPlace->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                        Edit
                    </a>
                    
                    <form action="{{ route('interesting-places.destroy', $interestingPlace->id) }}" method="POST" onsubmit="return confirm('Delete place permanently?')">
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
</x-app-layout>