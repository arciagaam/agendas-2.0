<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Add Building" />
    </div>
    <form method="POST" action="{{route('admin.information.buildings.store')}}">
        @csrf
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="name">Building Name</label>
                <input class="form-input" type="text" name="name" id="name">
                @error('name') <p class="text-red-500 text-sm"> {{$message}} </p> @enderror
            </div>
            <div class="flex flex-row gap-3">
                <x-anchor label="Cancel" type="inactive" url="{{route('admin.information.buildings.index')}}"/>
                <x-button label="Create"/>
            </div>
            
        </div>
    </form>
</x-main-layout>