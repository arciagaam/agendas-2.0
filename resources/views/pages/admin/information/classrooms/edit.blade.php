<x-main-layout>
    <form method="POST" action="{{route('admin.information.classrooms.update', ['classroom' => $classroom])}}">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="room_id">Room</label>

                <select class="form-input" name="room_id" id="room_id">
                    @foreach ($rooms as $room)
                        <option value="{{$room->id}}" @if ($room->id == $classroom->room_id) selected @endif>{{$room->name}}</option>
                    @endforeach 
                </select>
            </div>

            <div class="form-input-container">
                <label for="grade_level_id">Grade Level</label>

                <select class="form-input" name="grade_level_id" id="grade_level_id">
                    @foreach ($grade_levels as $grade_level)
                        <option value="{{$grade_level->id}}" @if ($grade_level->id == $classroom->grade_level_id) selected @endif>{{$grade_level->gr_level}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-input-container">
                <label for="section">Section</label>
                <input class="form-input" type="text" name="section" id="section" value="{{$classroom->section}}">
            </div>

            <div class="form-input-container">
                <label for="adviser_id">Adviser</label>
                <select class="form-input" name="adviser_id" id="adviser_id">
                    @foreach ($advisers as $adviser)
                        <option value="{{$adviser->adviser_id}}" @if ($adviser->adviser_id == $classroom_adviser->id) selected @endif>{{$adviser->honorific . ' ' . $adviser->first_name . ' ' . $adviser->last_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-input-container">
                <label for="class_link">Class Link (Online classroom)</label>
                <input class="form-input" type="text" name="class_link" id="class_link" value="{{$classroom->class_link}}">
            </div>

            <div class="flex flex-row gap-3">
                <x-anchor label="Cancel" type="inactive" url="{{route('admin.information.subjects.index')}}"/>
                <x-button label="Save"/>
            </div>
        </div>
    </form>
</x-main-layout>