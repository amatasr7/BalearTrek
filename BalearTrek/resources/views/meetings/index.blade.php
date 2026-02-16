<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">List of Meetings</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($meetings as $meeting)
                <div class="p-8 relative">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold uppercase text-gray-700">{{ $meeting->trek->name }}</h3>
                        <p class="text-md text-gray-600 font-semibold">{{ $meeting->day }} - {{ $meeting->time }}</p>
                    </div>

                    <div class="text-sm text-gray-600 space-y-1 mb-6">
                        <p><span class="font-bold">Guide:</span> {{ $meeting->guide?->name ?? 'No guide assigned' }}</p>
                        <p><span class="font-bold">Registrations:</span> {{ $meeting->appDateIni }} to {{ $meeting->appDateEnd }}</p>
                        <p><span class="font-bold text-xs uppercase">Score:</span> {{ $meeting->totalScore }} ({{ $meeting->countScore }} votes)</p>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('meetings.show', $meeting->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Show
                        </a>

                        <a href="{{ route('meetings.edit', $meeting->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Edit
                        </a>

                        <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Delete meeting?')">
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
                {{ $meetings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>