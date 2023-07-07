<x-main-layout>
    <form method="POST" action="{{route('admin.information.rooms.update', ['room' => $room])}}">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="name">Room Name</label>
                <input class="form-input" type="text" name="name" id="name" value="{{$room->name}}">
            </div>

            <div class="form-input-container">
                <label for="number">Room Number</label>
                <input class="form-input " type="number" name="number" id="number" value="{{$room->number}}">
            </div>

            <div class="form-input-container">
                <label for="building_id">Building</label>
                <select class="form-input" name="building_id" id="building_id">
                    <option value="">Select Building</option>

                    @foreach ($buildings as $building)
                        <option value="{{$building->id}}" @if ($building->id == $room->building_id) selected @endif>{{$building->name}}</option>
                    @endforeach
                </select>
            </div>

            <x-button label="Edit Room"/>
        </div>
    </form>
</x-main-layout>