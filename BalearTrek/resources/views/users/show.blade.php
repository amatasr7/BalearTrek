<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Details: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-user-card :user="$user" :showButton="false">
                {{-- Contenido extra que aparecerá en el slot --}}
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase">Contact</p>
                    <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase">Account Status</p>
                    <p><strong>Status:</strong> 
                        <span class="px-2 py-0.5 rounded text-xs font-bold uppercase {{ $user->status === 'y' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->status === 'y' ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
            </x-user-card>
        </div>
    </div>
</x-app-layout>