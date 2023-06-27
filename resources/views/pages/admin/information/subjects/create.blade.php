<x-main-layout>
    <form method="POST" action="{{route('admin.information.subjects.store')}}">
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="default_subject">Default Subject</label>
                <select class="form-input" name="default_subject" id="default_subject">
                    <option value="">Select Default Subject</option>
                    {{-- @foreach ($default_subjects as $default_subject)
                        <option value="{{$default_subject->id}}">{{$default_subject->name}}</option>
                    @endforeach --}}
                </select>
            </div>

            <div class="form-input-container">
                <label for="subject_name">Subject Name</label>
                <input class="form-input" type="text" name="subject_name" id="subject_name">
            </div>

            <div class="form-input-container">
                <label for="grade_level">Grade Level</label>
                <select class="form-input" name="grade_level" id="grade_level">
                    <option value="">Select Grade Level</option>
                    {{-- @foreach ($grade_levels as $grade_level)
                        <option value="{{$grade_level->id}}">{{$grade_level->name}}</option>
                    @endforeach --}}
                </select>
            </div>

            <div class="form-input-container">
                <label for="subject_code">Subject Code</label>
                <input class="form-input" type="text" name="subject_code" id="subject_code">
            </div>

            <div class="form-input-container">
                <label for="sp_count">Single Period Count</label>
                <input class="form-input" type="number" name="sp_count" id="sp_count">
            </div>

            <div class="form-input-container">
                <label for="dp_count">Double Period Count</label>
                <input class="form-input" type="number" name="dp_count" id="dp_count">
            </div>

            <div class="form-input-container">
                <label for="prio_num">Priority Number</label>
                <select class="form-input" name="prio_num" id="prio_num">
                    <option value="">Select Priority Number</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    {{-- @foreach ($grade_levels as $grade_level)
                        <option value="{{$grade_level->id}}">{{$grade_level->name}}</option>
                    @endforeach --}}
                </select>
            </div>

            <div class="form-input-container">
                <label for="subject_description">Subject Description</label>
                <textarea class="form-input" name="subject_description" id="subject_description" rows="10"></textarea>
            </div>

            <x-button label="Add Subject"/>
        </div>
    </form>
</x-main-layout>