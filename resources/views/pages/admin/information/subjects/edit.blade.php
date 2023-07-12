<x-main-layout>
    <form method="POST" action="{{route('admin.information.subjects.update', ['subject' => $subject])}}">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-5 w-1/2">

            <div class="form-input-container">
                <label for="default_subject_id">Default Subject</label>
                <select class="form-input" name="default_subject_id" id="default_subject_id">
                    <option value="">Select Default Subject</option>
                    @foreach ($default_subjects as $default_subject)
                        <option value="{{$default_subject->id}}" @if ($default_subject->id == $subject->default_subject_id) selected @endif>{{$default_subject->name}}</option>
                    @endforeach
                </select>

                @error('default_subject_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="subject_name">Subject Name</label>
                <input class="form-input" type="text" name="subject_name" id="subject_name" value="{{$subject->subject_name}}">
            </div>

            <div class="form-input-container">
                <label for="gr_level_id">Grade Level</label>
                <select class="form-input" name="gr_level_id" id="gr_level_id">
                    <option value="">Select Grade Level</option>
                    @foreach ($grade_levels as $grade_level)
                        <option value="{{$grade_level->id}}" @if ($grade_level->id == $subject->gr_level_id) selected @endif>{{$grade_level->gr_level}}</option>
                    @endforeach
                </select>

                @error('gr_level_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="subject_code">Subject Code</label>
                <input class="form-input" type="text" name="subject_code" id="subject_code" value="{{$subject->subject_code}}">
            </div>

            <div class="form-input-container">
                <label for="sp_frequency">Single Period Count</label>
                <input class="form-input" type="number" name="sp_frequency" id="sp_frequency" value="{{$subject->sp_frequency}}">
            </div>

            <div class="form-input-container">
                <label for="dp_frequency">Double Period Count</label>
                <input class="form-input" type="number" name="dp_frequency" id="dp_frequency" value="{{$subject->dp_frequency}}">
            </div>

            <div class="form-input-container">
                <label for="is_priority">Priority Subject</label>
                <select class="form-input" name="is_priority" id="is_priority">
                    <option value="1" @if ($priority_details) selected @endif>Yes</option>
                    <option value="0" @if (!$priority_details) selected @endif>No</option>
                </select>
            </div>

            <div class="form-input-container hidden" id="priority_time_div">
                <label for="priority_time">Priority Time</label>
                <input class="form-input" type="time" name="priority_time" id="priority_time" value="{{ $priority_details ? $priority_details->priority_time : '' }}">
                
                @error('priority_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container hidden" id="priority_day_div">
                <label for="priority_day">Priority Day</label>
                <select class="form-input" name="priority_day" id="priority_day">
                    <option value="">Select Day</option>
                    @foreach ($days as $day)
                        <option value="{{$day->id}}" @if ($priority_details && $priority_details->priority_day == $day->id) selected @endif>{{$day->name}}</option>
                    @endforeach
                </select>

                @error('priority_day')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-input-container">
                <label for="subject_description">Subject Description</label>
                <textarea class="form-input" name="subject_description" id="subject_description" rows="10">{{$subject->subject_description}}</textarea>
            </div>

            <x-button label="Edit Subject"/>
        </div>
    </form>
</x-main-layout>

@vite('resources/js/subject_priority.js')