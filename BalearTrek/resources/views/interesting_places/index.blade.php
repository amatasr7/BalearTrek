<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Llocs Remarcables') }}
            </h2>
            <a href="{{ route('interesting-places.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-xs uppercase font-bold transition">
                + Nou Lloc
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @foreach ($places as $place)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 relative">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold uppercase text-gray-700">{{ $place->name }}</h3>
                        <p class="text-sm text-blue-600 font-semibold italic">{{ $place->placeType->name ?? 'Sense tipus' }}</p>
                    </div>

                    <div class="text-sm text-gray-600 space-y-1 mb-6">
                        <p><span class="font-bold uppercase text-xs">GPS:</span> {{ $place->gps }}</p>
                        </div>

                    <div class="flex gap-2">
                        <a href="{{ route('interesting-places.show', $place) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Show
                        </a>

                        <a href="{{ route('interesting-places.edit', $place) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Edit
                        </a>

                        <form action="{{ route('interesting-places.destroy', $place) }}" method="POST" onsubmit="return confirm('Segur que vols eliminar aquest lloc?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm font-bold transition absolute bottom-8 right-8">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $places->links() }}
            </div>
        </div>
    </div>
</x-app-layout>