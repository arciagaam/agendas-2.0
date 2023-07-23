<x-main-layout>
    <form method="POST" action="{{route('admin.information.classrooms.store')}}">
        @csrf
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="room_id">Room</label>

                <select class="form-input" name="room_id" id="room_id">
                    @foreach ($rooms as $room)
                        <option value="{{$room->id}}" >{{$room->name}}</option>
                    @endforeach 
                </select>
            </div>

            <div class="form-input-container">
                <label for="grade_level_id">Grade Level</label>

                <select class="form-input" name="grade_level_id" id="grade_level_id">
                    @foreach ($grade_levels as $grade_level)
                        <option value="{{$grade_level->id}}" >{{$grade_level->gr_level}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-input-container">
                <label for="section">Section</label>
                <input class="form-input" type="text" name="section" id="section">
            </div>

            <div class="form-input-container">
                <label for="adviser_id">Adviser</label>
                <select class="form-input" name="adviser_id" id="adviser_id">
                    <option value="">Select an adviser</option>
                    @foreach ($advisers as $adviser)
                        <option value="{{$adviser->adviser_id}}">{{$adviser->honorific . ' ' . $adviser->first_name . ' ' . $adviser->last_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-input-container">
                <label for="class_link">Class Link (Online classroom)</label>
                <input class="form-input" type="text" name="class_link" id="class_link">
            </div>

            <x-button label="Add Classroom"/>
        </div>
    </form>
</x-main-layout>