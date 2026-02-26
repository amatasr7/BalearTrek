<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">List of Treks</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col">
                    @foreach($treks as $trek)
                        <x-trek-card :trek="$trek" />
                    @endforeach
                </div>
            </div>
            <div class="mt-8">
                {{ $treks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>