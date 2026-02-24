<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">List of Treks</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($treks as $trek)
                <div class="p-8 relative">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold uppercase text-gray-700">{{ $trek->name }}</h3>
                        <p class="text-md text-blue-600 font-bold italic">{{ $trek->difficulty }}</p>
                    </div>

                    <div class="text-sm text-gray-600 space-y-1 mb-6">
                        <p class="mb-4 text-sm">
            <strong>Municipality:</strong> {{ $trek->municipality->name ?? '—' }}
        </p>
                        <p class="mb-4 text-sm">
            <strong>Interesting Places:</strong>
        </p>
        <div class="mb-4">
            @foreach ($trek->interestingPlaces as $place)
                <span>
                    {{ $place->name }},
                </span>
            @endforeach
        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('treks.show', $trek->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">Show</a>
                        <a href="{{ route('treks.edit', $trek->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">Edit</a>
                        <form action="{{ route('treks.destroy', $trek->id) }}" method="POST" onsubmit="return confirm('Delete trek?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm font-bold transition absolute bottom-8 right-8">Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $treks->links() }}</div>
        </div>
    </div>
</x-app-layout>