<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Comment Detail #{{ $comment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-comment-card :comment="$comment" :showButton="false">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-500">
                    <div>
                        <p class="font-bold uppercase mb-1">System Info</p>
                        <p>Created: {{ $comment->created_at }}</p>
                        <p>Updated: {{ $comment->updated_at }}</p>
                    </div>
                    <div>
                        <p class="font-bold uppercase mb-1">Associated Media</p>
                        @forelse($comment->images as $img)
                            <p class="truncate">URL: <a href="{{ $img->url }}" target="_blank" class="text-blue-500 underline">{{ $img->url }}</a></p>
                        @empty
                            <p>No images attached.</p>
                        @endforelse
                    </div>
                </div>
            </x-user-card>
        </div>
    </div>
</x-app-layout>