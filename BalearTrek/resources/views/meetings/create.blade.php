<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Meeting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <form action="{{ route('meetings.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Guide</label>
                            <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Select a guide</option>
                                @foreach($guides as $guide)
                                    <option value="{{ $guide->id }}" {{ old('user_id') == $guide->id ? 'selected' : '' }}>
                                        {{ $guide->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="trek_id" class="block text-sm font-medium text-gray-700 mb-1">Trek</label>
                            <select name="trek_id" id="trek_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Select a trek</option>
                                @foreach($treks as $trek)
                                    <option value="{{ $trek->id }}" {{ old('trek_id') == $trek->id ? 'selected' : '' }}>
                                        {{ $trek->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('trek_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Meeting Day</label>
                            <input type="date" name="day" id="day" value="{{ old('day') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('day') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Meeting Time</label>
                            <input type="time" name="time" id="time" value="{{ old('time') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="appDateIni" class="block text-sm font-medium text-gray-700 mb-1">Application Starts</label>
                            <input type="date" name="appDateIni" id="appDateIni" value="{{ old('appDateIni') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label for="appDateEnd" class="block text-sm font-medium text-gray-700 mb-1">Application Ends</label>
                            <input type="date" name="appDateEnd" id="appDateEnd" value="{{ old('appDateEnd') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                    </div>

                    <div class="mt-6 flex items-center">
                        <input type="hidden" name="publicat" value="0">
                        <input type="checkbox" name="publicat" id="publicat" value="1" {{ old('publicat') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <label for="publicat" class="ml-2 block text-sm text-gray-900">Publish immediately</label>
                    </div>

                    <div class="flex items-center justify-end mt-8 border-t pt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded shadow transition">
                            Create Meeting
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>