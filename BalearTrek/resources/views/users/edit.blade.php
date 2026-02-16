<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight italic">Editing User: {{ $user->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-8">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">First Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <br>
                        {{-- Lastname --}}
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">Last Name</label>
                            <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <br>
                        {{-- Email --}}
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <br>
                        {{-- Role ID --}}
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">Role ID</label>
                            <input type="number" name="role_id" value="{{ old('role_id', $user->role_id) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t flex justify-end gap-3">
                        <a href="{{ route('users.index') }}" class="text-gray-500 font-bold px-4 py-2 hover:underline">Cancel</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-bold transition shadow-sm">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>