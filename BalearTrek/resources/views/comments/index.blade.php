<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comment Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                
                @foreach($comments as $comment)
                    <div class="{{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <x-comment-card :comment="$comment" />
                    </div>
                @endforeach

                @if($comments->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        No comments found.
                    </div>
                @endif
            </div>

            <div class="mt-8">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>