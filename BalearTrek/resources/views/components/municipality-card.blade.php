@props(['municipality', 'showButton' => true])

<div class="block rounded-lg bg-white shadow-secondary-1 mb-4">
    <div class="p-6 text-surface relative">
        <h5 class="mb-2 text-xl font-medium leading-tight">{{$municipality->name}}</h5>
        
        <p class="mb-4 text-sm">Island: {{$municipality->island->name ?? 'N/A'}}</p>
        <p class="mb-4 text-sm">Zone: {{$municipality->zone->name ?? 'N/A'}}</p>
        <p class="mb-4 text-sm text-gray-400">created at: {{ $municipality->created_at }}</p>

        <div class="flex gap-2">
            @if($showButton)
                <a href="{{route('municipis.show' , ['municipi' => $municipality->id])}}" 
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                   Show
                </a>
            @endif

            <a href="{{route('municipis.edit' , ['municipi' => $municipality->id ])}}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
               Edit
            </a>

            <form action="{{route('municipis.destroy' , ['municipi' => $municipality->id ])}}" method="POST" class="absolute right-6 bottom-6">
                @method('DELETE')
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm" onclick="return confirm('¿Borrar?')">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>