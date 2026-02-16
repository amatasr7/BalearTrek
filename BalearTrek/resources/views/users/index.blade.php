<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($users as $user)
                <div class="p-8 relative">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold uppercase text-gray-700">
                            {{ $user->name }} {{ $user->lastname ?? '' }}
                        </h3>
                    </div>

                    <div class="text-sm text-gray-600 space-y-1 mb-6">
                        <p><span class="font-bold">Email:</span> {{ $user->email }}</p>
                        <p>

                        </p>
                        @if($user->dni)
                            <p><span class="font-bold">DNI:</span> {{ $user->dni }}</p>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('users.show', $user->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Show
                        </a>
                        
                        <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Edit
                        </a>

                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded text-sm font-bold transition absolute bottom-8 right-8">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>