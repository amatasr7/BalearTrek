<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of Interesting Places') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                @foreach($interestingPlaces as $place)
                    <div class="p-8 relative">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold uppercase text-gray-700">{{ $place->name }}</h3>
                            <p class="text-md text-gray-600 font-semibold">{{ $place->placeType->name ?? 'Sin tipo' }}</p>
                        </div>

                        <div class="text-sm text-gray-600 mb-6">
                            <p><span class="font-bold">GPS:</span> {{ $place->gps }}</p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('interesting-places.show', $place->id) }}" 
                               class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                                Show
                            </a>
                            
                            <a href="{{ route('interesting-places.edit', $place->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                                Edit
                            </a>

                            <form action="{{ route('interesting-places.destroy', $place->id) }}" method="POST" onsubmit="return confirm('¿Borrar lugar?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm font-bold transition absolute bottom-8 right-8">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div> <div class="mt-8">
                {{ $interestingPlaces->links() }}
            </div>

        </div>
    </div>
</x-app-layout>