<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">List of Meetings</h2>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    @foreach($meetings as $meeting)
                        <x-meeting-card :meeting="$meeting" />
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                {{ $meetings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>