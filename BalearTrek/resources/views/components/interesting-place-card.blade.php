@props(['place', 'showButton' => true])

<div class="block rounded-lg bg-white shadow-secondary-1">
    <div class="p-6 text-surface">
        <h5 class="mb-2 text-xl font-medium leading-tight">{{$place->name}}</h5>
        <p class="mb-4 text-sm">GPS: {{$place->gps}}</p>
        <p class="mb-4 text-sm">Lugar: {{$place->placeType->name}}</p>
        <p class="mb-4 text-sm">created at: {{ $place->created_at }}</p>
        <p class="mb-4 text-sm">updated at: {{ $place->updated_at }}</p>
        @if($showButton)
            <a href="{{route('interesting-places.show' , ['interesting_place' => $place->id])}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        @endif
        <a href="{{route('interesting-places.edit' , ['interesting_place' => $place->id ])}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="{{route('interesting-places.destroy' , ['interesting_place' => $place->id ])}}" method="POST" class="float-right">
           @method('DELETE')
           @csrf
           <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" >Delete</button>
        </form>
    </div>
</div>