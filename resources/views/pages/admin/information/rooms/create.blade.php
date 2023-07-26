<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Add Room" />
    </div>
    <form method="POST" action="{{route('admin.information.rooms.store')}}">
        @csrf
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="name">Room Name</label>
                <input class="form-input" type="text" name="name" id="name">
                @error('name') <p class="text-red-500 text-sm"> {{$message}} </p> @enderror
            </div>

            <div class="form-input-container">
                <label for="number">Room Number</label>
                <input class="form-input " type="number" name="number" id="number">
                @error('number') <p class="text-red-500 text-sm"> {{$message}} </p> @enderror
            </div>

            <div class="form-input-container">
                <label for="building_id">Building</label>
                <select class="form-input" name="building_id" id="building_id">
                    <option value="">Select Building</option>

                    @foreach ($buildings as $building)
                        <option value="{{$building->id}}">{{$building->name}}</option>
                    @endforeach
                </select>
                @error('building_id') <p class="text-red-500 text-sm"> {{$message}} </p> @enderror
            </div>

            <div class="flex flex-row gap-3">
                <x-anchor label="Cancel" type="inactive" url="{{route('admin.information.rooms.index')}}"/>
                <x-button label="Create"/>
            </div>
        </div>
    </form>
</x-main-layout>