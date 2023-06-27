<x-main-layout>
    <form method="POST" action="{{route('admin.information.rooms.store')}}">
        @csrf
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="honorific">Honorific</label>
                <select class="form-input" name="honorific" id="honorific">
                    <option value="">Select Honorific</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Mx.">Mx.</option>
                </select>
            </div>

            <div class="form-input-container">
                <label for="last_name">Last Name</label>
                <input class="form-input" type="text" name="last_name" id="last_name">
            </div>
            
            <div class="form-input-container">
                <label for="first_name">First Name</label>
                <input class="form-input" type="text" name="first_name" id="first_name">
            </div>

            <div class="form-input-container">
                <label for="middle_name">Middle Name</label>
                <input class="form-input" type="text" name="middle_name" id="middle_name">
            </div>

            <div class="form-input-container">
                <label for="max_hrs">Max Hours</label>
                <input class="form-input " type="number" name="max_hrs" id="max_hrs">
            </div>

            <div class="form-input-container">
                <label for="regular_load">Regular Load</label>
                <input class="form-input " type="number" name="regular_load" id="regular_load">
            </div>

            <div class="form-input-container">
                <label for="is_adviser">Adviser</label>
                <select class="form-input" name="honorific" id="honorific">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="form-input-container">
                <label for="teacher_id">ID Number</label>
                <input class="form-input" type="text" name="teacher_id" id="teacher_id">
            </div>

            <x-button label="Add Teacher"/>
        </div>
    </form>
</x-main-layout>