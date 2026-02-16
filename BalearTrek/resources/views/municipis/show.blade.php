<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show Municipi : {{ $municipi->name }}
            </h2>
            <a href="{{ route('municipis.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-xs uppercase font-bold transition">
                Tornar al llistat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 relative">
                <div class="mb-4">
                    <h3 class="text-lg font-bold uppercase text-gray-700">{{ $municipi->name }}</h3>
                    <p class="text-md text-gray-600 font-semibold">Codi ID: {{ $municipi->id }}</p>
                </div>

                <div class="text-sm text-gray-600 space-y-1 mb-6">
                    <p><span class="font-bold">Illa:</span> {{ $municipi->island->name ?? 'N/A' }}</p>
                    <p><span class="font-bold">Zona:</span> {{ $municipi->zone->name ?? 'N/A' }}</p>
                    <p><span class="font-bold text-xs uppercase text-gray-400">posted: yes</span></p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100 text-xs text-gray-400">
                        <p>created at: {{ $municipi->created_at->format('Y-m-d H:i:s') }}</p>
                        <p>updated at: {{ $municipi->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('municipis.show', $municipi->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">Show</a>
                    <a href="{{ route('municipis.edit', $municipi->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">Edit</a>
                    <form action="{{ route('municipis.destroy', $municipi->id) }}" method="POST" onsubmit="return confirm('Esborrar municipi?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm font-bold transition absolute bottom-8 right-8">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>