@props(['user', 'showButton' => true])

<div class="block rounded-lg bg-white shadow-sm border border-gray-100 mb-4">
    <div class="p-8 relative">
        <div class="mb-4">
            <h3 class="text-xl font-bold uppercase text-gray-700">
                {{ $user->name }} {{ $user->lastname ?? '' }}
            </h3>
            <p class="text-sm font-bold text-blue-600 italic">
                Rol: {{ $user->role->name ?? 'Sin Rol' }}
            </p>
        </div>

        <div class="text-sm text-gray-600 space-y-2 mb-6">
            <p><span class="font-bold">Email:</span> {{ $user->email }}</p>
            
            @if($user->dni)
                <p><span class="font-bold">DNI:</span> {{ $user->dni }}</p>
            @endif

            {{-- Slot para información extra del "Show" --}}
            @if(isset($slot) && $slot->isNotEmpty())
                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{ $slot }}
                </div>
            @endif

            <div class="mt-4 pt-4 text-xs text-gray-400">
                <p>Member since: {{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="flex gap-2">
            @if($showButton)
                <a href="{{ route('users.show', ['user' => $user->id]) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded text-sm font-bold transition">
                    Show
                </a>
            @endif

            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm font-bold transition">
                Edit
            </a>

            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar usuario?')">
                @csrf 
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded text-sm font-bold transition absolute bottom-8 right-8">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>