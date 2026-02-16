<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Trek') }} : {{ $trek->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('treks.update', $trek->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Title of the Trek</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $trek->name) }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="distance" class="block text-sm font-medium text-gray-700 mb-1">Distance (km)</label>
                            <input type="number" step="0.1" name="distance" id="distance" value="{{ old('distance', $trek->distance) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <br>
                        <div>
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (min)</label>
                            <input type="number" name="duration" id="duration" value="{{ old('duration', $trek->duration) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-1">Difficulty</label>
                        <select name="difficulty" id="difficulty" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Fàcil" {{ $trek->difficulty == 'Fàcil' ? 'selected' : '' }}>Easy</option>
                            <option value="Moderada" {{ $trek->difficulty == 'Moderada' ? 'selected' : '' }}>Moderate</option>
                            <option value="Difícil" {{ $trek->difficulty == 'Difícil' ? 'selected' : '' }}>Difficult</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $trek->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition duration-150">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>