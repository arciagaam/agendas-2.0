<x-main-layout>
    <form method="POST" action="{{route('admin.information.buildings.store')}}">
        @csrf
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="name">Building Name</label>
                <input class="form-input" type="text" name="name" id="name">
            </div>

            <x-button label="Add Building"/>
        </div>
    </form>
</x-main-layout>