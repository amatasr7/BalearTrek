<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Lloc Interessant') }} : {{ $interestingPlace->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('interesting-places.update', $interestingPlace) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $interestingPlace->name) }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <label for="gps" class="block text-sm font-medium text-gray-700 mb-1">GPS Location</label>
                        <input type="text" name="gps" id="gps" value="{{ old('gps', $interestingPlace->gps) }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('gps') border-red-500 @enderror">
                        <x-input-error :messages="$errors->get('gps')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <label for="place_type_id" class="block text-sm font-medium text-gray-700 mb-1">Type of Place</label>
                        <select name="place_type_id" id="place_type_id" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('place_type_id') border-red-500 @enderror">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('place_type_id', $interestingPlace->place_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('place_type_id')" class="mt-2" />
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