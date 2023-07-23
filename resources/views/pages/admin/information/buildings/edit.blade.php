<x-main-layout>
    <form method="POST" action="{{route('admin.information.buildings.update', ['building' => $building])}}">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="name">Building Name</label>
                <input class="form-input" type="text" name="name" id="name" value="{{$building->name}}">
            </div>

            <x-button label="Edit Building"/>
        </div>
    </form>
</x-main-layout>