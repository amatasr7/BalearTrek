@props(['trek', 'showButton' => true])

<div class="block rounded-lg bg-white shadow-sm border border-gray-100 mb-4">
    <div class="p-8 relative">
        <div class="mb-4">
            <h3 class="text-xl font-bold uppercase text-gray-700">{{ $trek->name }}</h3>
            <p class="text-md text-blue-600 font-bold italic">{{ $trek->difficulty }}</p>
        </div>

        <div class="text-sm text-gray-600 space-y-2 mb-6">
            <p><span class="font-bold">Register Number:</span> {{$trek->regNumber}}</p>
            <p><span class="font-bold">Status:</span> {{$trek->status}}</p>
            <p><span class="font-bold">Municipality:</span> {{ $trek->municipality->name ?? '—' }}</p>
            
            <div>
                <span class="font-bold">Interesting Places:</span>
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach ($trek->interestingPlaces as $place)
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">
                            {{ $place->name }}
                        </span>
                    @endforeach
                </div>
            </div>

            @if(isset($slot) && $slot->isNotEmpty())
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="font-bold text-gray-700 mb-2">Description</h4>
                    <div class="text-gray-600 italic leading-relaxed">
                        {!! $slot !!}
                    </div>
                </div>
            @endif

            <div class="mt-4 pt-4 text-xs text-gray-400">
                <p>Created: {{ $trek->created_at->format('d/m/Y H:i') }}</p>
                <p>Updated: {{ $trek->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="flex gap-2">
            @if($showButton)
                <a href="{{ route('treks.show', $trek->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded text-sm font-bold transition">Show</a>
            @endif
            <a href="{{ route('treks.edit', $trek->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-bold transition">Edit</a>
            
            <form action="{{ route('treks.destroy', $trek->id) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded text-sm font-bold transition absolute bottom-8 right-8" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </div>
    </div>
</div>