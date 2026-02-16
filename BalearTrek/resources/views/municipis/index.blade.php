<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestió de Municipis') }}
            </h2>
            <a href="{{ route('municipis.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-xs uppercase font-bold transition">
                + Nou Municipi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensajes de éxito o error --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="space-y-6">
                @foreach ($municipis as $municipi)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 relative">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold uppercase text-gray-700">{{ $municipi->name }}</h3>
                        <p class="text-sm text-gray-500 font-semibold italic">ID: {{ $municipi->id }}</p>
                    </div>

                    <div class="text-sm text-gray-600 space-y-1 mb-6">
                        <p><span class="font-bold uppercase text-xs">Illa:</span> {{ $municipi->island->name ?? 'N/A' }}</p>
                        <p><span class="font-bold uppercase text-xs">Zona:</span> {{ $municipi->zone->name ?? 'N/A' }}</p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('municipis.show', $municipi) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Show
                        </a>

                        <a href="{{ route('municipis.edit', $municipi) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Edit
                        </a>

                        <form action="{{ route('municipis.destroy', $municipi) }}" method="POST" onsubmit="return confirm('Estàs segur que vols eliminar aquest municipi?')">
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
                {{ $municipis->links() }}
            </div>
        </div>
    </div>
</x-app-layout>