<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Teacher Assignment" />
    </div>

    <x-table.actions>

        <div class="form-input-container">
            <label class="text-sm" for="search">Search</label>

            <div class="flex items-center border rounded-lg overflow-hidden py-1 px-2 bg-white">
                <input class="outline-none border-inherit text-sm" type="text" id="search" name="search">
                <box-icon name='search' size='xs' class="text-xs"></box-icon>
            </div>
        </div>


        <div class="form-input-container">
            <label class="text-sm" for="rows">Rows</label>

            <select class="form-input text-sm" name="rows" id="rows">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="75">75</option>
                <option value="100">100</option>
            </select>
        </div>

        <div class="form-input-container">
            <label class="text-sm" for="gr_level_id">Grade level</label>

            <select class="form-input" name="gr_level_id" id="gr_level_id" onchange="this.form.submit()">
                @foreach ($grade_levels as $grade_level)
                    <option value="{{ $grade_level->id }}" @if ($grade_level->id == $subjects[0]->gr_level_id) selected @endif>{{ $grade_level->gr_level }}</option>
                @endforeach
            </select>
        </div>


    </x-table.actions>

    @php
        $classrooms = [
            collect([
                'subject_name' => 'Math 1',
                'subject_code' => 'MATH-1',
                'grade_level_id' => '1',
                'assigned_teachers' => 'Teacher 1',
            ]),
        
            collect([
                'subject_name' => 'English 1 ',
                'subject_code' => 'ENG-1',
                'grade_level_id' => '1',
                'assigned_teachers' => 'Teacher 2',
            ]),
        
            collect([
                'subject_name' => 'Science 1',
                'subject_code' => 'SCI-1',
                'grade_level_id' => '1',
                'assigned_teachers' => 'Teacher 3',
            ]),
        
            collect([
                'subject_name' => 'Filipino 1',
                'subject_code' => 'FIL-1',
                'grade_level_id' => '1',
                'assigned_teachers' => 'Teacher 4',
            ]),
        ];
    @endphp

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Subject Name</x-table.td>
                <x-table.td :isHeader="true">Subject Code</x-table.td>
                <x-table.td :isHeader="true">Assigned Teachers</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($subjects as $index => $subject)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{ $subject['subject_name'] }}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{ $subject['subject_code'] }}</x-table.td>
                    <x-table.td :trPosition="$loop->last">
                        <div class="form-input-container">
            
                                <div class="relative flex flex-col max-w-[400px]">
                                    <div id="{{$subject->id}}" class="selected-teachers flex flex-col gap-2 py-2 px-3 rounded-lg border border-gray-3 overflow-hidden focus-within:rounded-b-none transition-all">
                                        <input id="{{$subject->default_subject_id}}" name="search_teacher" class="search-teacher outline-none min-w-[40px] flex-1 text-regular" type="text" disabled>
                                    </div>
                
                                    <div id="teachers_container_{{$subject->default_subject_id}}" aria-hidden="true" class="z-50 teachers-container absolute top-[100%] bg-project-dominant border border-t-0 rounded-b-lg border-gray-3 p-2 w-full flex flex-col aria-hidden:hidden gap-2">
                                    </div>
                                </div>
                        </div>
                    </x-table.td>
                    <x-table.td :trPosition="$loop->last">
                        <x-page.actions>
                            <x-button label="Edit" type="secondary" class="edit-assignment-btn" id="edit_button_{{$subject->default_subject_id}}">
                                <x-slot:icon>
                                    <box-icon name='edit'></box-icon>
                                </x-slot:icon>
                            </x-button>
                        </x-page.actions>
                    </x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>

@vite('resources/js/teacher_assignment.js');