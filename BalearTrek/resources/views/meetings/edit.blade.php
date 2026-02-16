<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Meeting') }} : {{ $meeting->trek->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('meetings.update', $meeting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1 text-gray-400">Trek (No editable)</label>
                        <input type="text" value="{{ $meeting->trek->name }}" class="w-full border-gray-200 bg-gray-50 rounded-md text-gray-500" disabled>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                            <input type="date" name="day" id="day" value="{{ old('day', $meeting->day) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <br>
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                            <input type="time" name="time" id="time" value="{{ old('time', $meeting->time) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Guide Assigned</label>
                        <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">No guide</option>
                            @foreach($guides as $guide)
                                <option value="{{ $guide->id }}" {{ $meeting->user_id == $guide->id ? 'selected' : '' }}>
                                    {{ $guide->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="publicat" class="block text-sm font-medium text-gray-700 mb-1">Published</label>
                        <select name="publicat" id="publicat" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="1" {{ $meeting->publicat ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$meeting->publicat ? 'selected' : '' }}>No</option>
                        </select>
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