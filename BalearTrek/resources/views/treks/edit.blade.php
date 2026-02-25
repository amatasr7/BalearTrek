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
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Title of the Trek</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $trek->name) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 @error('name') border-red-500 @enderror">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <br></br>
                        <div>
                            <label for="regNumber" class="block text-sm font-medium text-gray-700 mb-1">Registration Number</label>
                            <input type="text" name="regNumber" id="regNumber" value="{{ old('regNumber', $trek->regNumber) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 @error('regNumber') border-red-500 @enderror">
                            <x-input-error :messages="$errors->get('regNumber')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <x-input-label for="municipality_id" value="Municipality" />
                            <select id="municipality_id" name="municipality_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                @foreach ($municipalities as $municipality)
                                    <option value="{{ $municipality->id }}"
                                        {{ old('municipality_id', $trek->municipality_id) == $municipality->id ? 'selected' : '' }}>
                                        {{ $municipality->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('municipality_id')" class="mt-2" />
                        </div>
                        <br></br>
                        <div>
                            <x-input-label value="Interesting Places" />
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                @foreach ($places as $place)
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox"
                                            name="places[]" 
                                            value="{{ $place->id }}"
                                            {{ in_array($place->id, old('places', $trek->interestingPlaces->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600">{{ $place->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('places')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="4" 
                            class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $trek->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-start mt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow">
                            Update Trek
                        </button>
                    </div>
                        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
                        <script>

        ClassicEditor

            .create( document.querySelector( '#description' ), {

                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],

            })

            .catch( error => {

                console.error( error );

            } );

    </script>
                </form>
            </div>
        </div>
    </div>
    
    </x-app-layout>