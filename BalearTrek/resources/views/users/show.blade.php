<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User Details: {{ $user->name }}</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 relative">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 uppercase">{{ $user->name }} {{ $user->lastname }}</h3>
                        <p class="text-gray-400 text-sm italic border-t pt-2 mt-2">Member since {{ $user->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                        <div>
                            <p class="text-sm font-bold text-gray-500 uppercase">Contact Information</p>
                            <p class="text-lg"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="text-lg"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                        </div>
                        <br>
                        <div>
                            <p class="text-sm font-bold text-gray-500 uppercase">Identification & Role</p>
                            <p class="text-lg"><strong>DNI:</strong> {{ $user->dni }}</p>
                            <p class="text-lg"><strong>Role ID:</strong> <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded text-sm font-bold uppercase">{{ $user->role_id }}</span></p>
                            <p class="text-lg"><strong>Status:</strong> <span class="uppercase font-mono">{{ $user->status }}</span></p>
                        </div>
                        <br>
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">Account Status</label>
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="y" {{ old('status', $user->status) === 'y' ? 'selected' : '' }}>Active (y)</option>
                                <option value="n" {{ old('status', $user->status) === 'n' ? 'selected' : '' }}>Inactive / Banned (n)</option>
                            </select>
                            <p class="text-xs text-gray-400 mt-1 italic text-lowercase">"n" effectively "unregisters" the user from active service.</p>
                        </div>
                    </div>

                    <div class="mt-10 flex gap-2">
                        <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-bold transition shadow-sm">Edit User</a>
                        <a href="{{ route('users.show', $user->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm font-bold transition">
                            Show
                        </a>                    
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>