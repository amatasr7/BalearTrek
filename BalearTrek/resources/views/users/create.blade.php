<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action="{{ route('users.store') }}" method="POST" class="p-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">Name</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">Email</label>
                            <input type="email" name="email" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">Password</label>
                            <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-bold text-gray-700 uppercase text-xs mb-2">Role ID</label>
                            <input type="number" name="role_id" value="2" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t flex justify-end gap-3">
                        <a href="{{ route('users.index') }}" class="text-gray-500 font-bold px-4 py-2">Cancel</a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded font-bold transition shadow-sm">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>