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
                        <div class="mb-4">
            <x-input-label for="municipality_id" value="Municipality" />
            <select id="municipality_id" name="municipality_id"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                @foreach ($municipalities as $municipality)
                    <option value="{{ $municipality->id }}"
                        {{ $trek->municipality_id == $municipality->id ? 'selected' : '' }}>
                        {{ $municipality->name }}
                    </option>
                @endforeach

            </select>
            <x-input-error :messages="$errors->get('municipality_id')" class="mt-2" />
        </div>
                        <br>
                        <div class="mb-4">
            <div class="grid grid-cols-2 gap-2 mt-2">
                @foreach ($places as $place)
                    <label class="flex items-center gap-2">
                        <input type="checkbox"
                            name="interesting_places[]"
                            value="{{ $place->id }}"
                            {{ $trek->interestingPlaces->contains($place->id) ? 'checked' : '' }}>
                        {{ $place->name }}
                    </label>
                @endforeach
            </div>
        </div>
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

    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }
    </style>
</x-app-layout>