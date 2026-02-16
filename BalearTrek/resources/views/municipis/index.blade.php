<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">List of Municipalities</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($municipis as $municipi)
                <div class="p-8 relative">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold uppercase text-gray-700">{{ $municipi->name }}</h3>
                    </div>

                    <div class="text-sm text-gray-600 space-y-1 mb-6">
                        <p><span class="font-bold">Island:</span> {{ $municipi->island->name ?? 'N/A' }}</p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('municipis.show', $municipi->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">Show</a>
                        <a href="{{ route('municipis.edit', $municipi->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">Edit</a>
                        <form action="{{ route('municipis.destroy', $municipi->id) }}" method="POST" onsubmit="return confirm('Delete municipality?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm font-bold transition absolute bottom-8 right-8">Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $municipis->links() }}</div>
        </div>
    </div>
</x-app-layout>