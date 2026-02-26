@props(['meeting'])

<div class="block rounded-lg bg-white shadow-lg border border-gray-200">
    <div class="p-6 text-surface">
        <h3 class="mb-2 text-xl font-bold uppercase text-gray-700">{{ $meeting->trek->name }}</h3>
        <div class="space-y-1 mb-4">
            <p class="text-sm"><span class="font-bold">Inscription opens:</span> {{ $meeting->appDateIni }}</p>
            <p class="text-sm"><span class="font-bold">Inscription ends:</span> {{ $meeting->appDateEnd }}</p>
            <p class="text-sm"><span class="font-bold">Date and Time:</span> {{ $meeting->day }} a las {{ $meeting->time }}</p>
            <p class="text-sm">
                <span class="font-bold">Guide:</span> 
                {{ $meeting->user->name }} {{ $meeting->user->lastname ?? '' }}
            </p>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100 text-xs text-gray-400">
            <p>Created at: {{ $meeting->created_at }}</p>
            <p>Updated at: {{ $meeting->updated_at }}</p>
        </div>
        <div class="mt-6 flex gap-2">
            <a href="{{ route('meetings.show', $meeting->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                Show
            </a>
            <a href="{{ route('meetings.edit', $meeting->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                Edit
            </a>
            <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" class="inline-block ml-auto" onsubmit="return confirm('¿Estás seguro?')">
                @method('DELETE')
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>