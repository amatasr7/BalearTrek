<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Meeting') }} : {{ $meeting->trek->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                {{-- Formulario --}}
                <form action="{{ route('meetings.update', $meeting->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="trek_id" class="block text-sm font-medium text-gray-700 mb-1">Trek / Excursión</label>
                        <select name="trek_id" id="trek_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500">
                            @foreach($treks as $trek)
                                <option value="{{ $trek->id }}" {{ old('trek_id', $meeting->trek_id) == $trek->id ? 'selected' : '' }}>
                                    {{ $trek->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('trek_id')" class="mt-2" />
                    </div>
                    <br></br>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Meeting Date</label>
                            <input type="date" name="day" id="day" value="{{ old('day', $meeting->day) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm">
                            <x-input-error :messages="$errors->get('day')" class="mt-2" />
                        </div>
                        <br></br>
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Meeting Time</label>
                            <input type="time" name="time" id="time" value="{{ old('time', \Carbon\Carbon::parse($meeting->time)->format('H:i')) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm">
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
                        </div>
                    </div>
                    <br></br>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="appDateIni" class="block text-sm font-medium text-gray-700 mb-1">Registration Start Date</label>
                            <input type="date" name="appDateIni" id="appDateIni" value="{{ old('appDateIni', $meeting->appDateIni) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm">
                            <x-input-error :messages="$errors->get('appDateIni')" class="mt-2" />
                        </div>
                        <br></br>
                        <div>
                            <label for="appDateEnd" class="block text-sm font-medium text-gray-700 mb-1">Registration End Date</label>
                            <input type="date" name="appDateEnd" id="appDateEnd" value="{{ old('appDateEnd', $meeting->appDateEnd) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm">
                            <x-input-error :messages="$errors->get('appDateEnd')" class="mt-2" />
                        </div>
                    </div>
                    <br></br>
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Guide Assigned</label>
                        <select name="user_id" id="user_id" class="w-full border-gray-300 rounded-md shadow-sm">
                            {{-- Si el controlador pide 'required', esta opción dará error si se elige --}}
                            <option value="">Select a guide...</option> 
                            @foreach($guides as $guide)
                                <option value="{{ $guide->id }}" {{ old('user_id', $meeting->user_id) == $guide->id ? 'selected' : '' }}>
                                    {{ $guide->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>
                    <br></br>
                    <div class="mb-6">
                        <label for="publicat" class="block text-sm font-medium text-gray-700 mb-1">Published</label>
                        <select name="publicat" id="publicat" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="1" {{ old('publicat', $meeting->publicat) ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !old('publicat', $meeting->publicat) ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <br></br>
                    <div class="flex items-center justify-start mt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow">
                            Update Meeting
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>