<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Edit Room Information" />
    </div>
    <form method="POST" action="{{route('admin.information.rooms.update', ['room' => $room])}}">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="name">Room Name</label>
                <input class="form-input" type="text" name="name" id="name" value="{{$room->name}}">
                @error('name') <p class="text-red-500 text-sm"> {{$message}} </p> @enderror
            </div>

            <div class="form-input-container">
                <label for="number">Room Number</label>
                <input class="form-input " type="number" name="number" id="number" value="{{$room->number}}">
                @error('number') <p class="text-red-500 text-sm"> {{$message}} </p> @enderror
            </div>

            <div class="form-input-container">
                <label for="building_id">Building</label>
                <select class="form-input" name="building_id" id="building_id">
                    <option value="">Select Building</option>

                    @foreach ($buildings as $building)
                        <option value="{{$building->id}}" @if ($building->id == $room->building_id) selected @endif>{{$building->name}}</option>
                    @endforeach
                </select>
                @error('building_id') <p class="text-red-500 text-sm"> {{$message}} </p> @enderror
            </div>

            <div class="flex flex-row gap-3">
                <x-anchor label="Cancel" type="inactive" url="{{route('admin.information.rooms.index')}}"/>
                <x-button label="Save"/>
            </div>
        </div>
    </form>
</x-main-layout>