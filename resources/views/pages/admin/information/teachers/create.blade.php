<x-main-layout>
    <form method="POST" action="{{route('admin.information.teachers.store')}}">
        @csrf
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="honorific_id">Honorific</label>
                <select class="form-input" name="honorific_id" id="honorific_id">
                    <option value="">Select Honorific</option>
                    <option value=1>Mr.</option>
                    <option value=2>Mrs.</option>
                    <option value=3>Ms.</option>
                    <option value=4>Mx.</option>
                </select>

                @error('honorific_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="last_name">Last Name</label>
                <input class="form-input" type="text" name="last_name" id="last_name">

                @error('last_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-input-container">
                <label for="first_name">First Name</label>
                <input class="form-input" type="text" name="first_name" id="first_name">

                @error('first_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="middle_name">Middle Name</label>
                <input class="form-input" type="text" name="middle_name" id="middle_name">

                @error('middle_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="max_hours">Max Hours</label>
                <input class="form-input " type="number" name="max_hours" id="max_hours">

                @error('max_hrs')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="regular_load">Regular Load</label>
                <input class="form-input " type="number" name="regular_load" id="regular_load">

                @error('regular_load')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="is_adviser">Adviser</label>
                <select class="form-input" name="is_adviser" id="is_adviser">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>

                @error('is_adviser')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="username">ID Number</label>
                <input class="form-input" type="text" name="username" id="username">

                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <x-button label="Add Teacher"/>
        </div>
    </form>
</x-main-layout>