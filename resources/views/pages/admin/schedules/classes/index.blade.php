<x-main-layout>    
        <div class="flex justify-between items-center">
            <x-page.header title="Class Schedule" />
            <x-page.actions>
                @if (request()->classroom_id && request()->grade_level_id)
                    <x-button id="save_schedule" label="Save" type="primary">
                        <x-slot:icon>
                            <box-icon name='save'></box-icon>
                        </x-slot:icon>
                    </x-button>
                @endif
            </x-page.actions>
        </div>

        <div class="flex flex-col gap-5">
            <x-table.actions class="border border-project-gray-default">
                <div class="form-input-container">
                    <label class="text-sm" for="grade_level_id">Grade Level</label>
                    
                    <select class="form-input text-sm" name="grade_level_id" id="grade_level_id" onchange="this.form.submit()">
                        <option value="{{null}}">Select a grade level</option>
                        @foreach ($gradeLevels as $gradeLevel)
                            <option value="{{$gradeLevel->id}}" @selected(request()->grade_level_id == $gradeLevel->id)>{{$gradeLevel->gr_level}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-input-container">
                    <label class="text-sm" for="classroom_id">Section</label>
                    
                    <select class="form-input text-sm" name="classroom_id" id="classroom_id" onchange="this.form.submit()">
                        <option value="">Select a section</option>
                        @foreach ($sections as $section)
                            <option value="{{$section->id}}" @selected(request()->classroom_id == $section->id)>{{$section->section}}</option>
                        @endforeach
                    </select>
                </div>
            </x-table.actions>

            <input id="classroom_id" type="hidden" value="{{request()->classroom_id}}">
            @if (request()->classroom_id && request()->grade_level_id)
                @for ($tables = 0; $tables < getTimetableCount($classSchedule); $tables++)

                    <div id="table_container" class="flex flex-wrap p-4 gap-5 border border-project-gray-default rounded-lg">
                        <table data-tableNumber="1" class="table-auto border-separate border-spacing-2">
                            <thead>
                                <tr class="relative text-center">

                                    <th>Time</th>
                                    @foreach (getTimetableDays($classSchedule, $tables+1) as $day_id => $day)
                                        <th aria-colindex="{{$day->id}}">
                                            <div class="flex flex-col w-full">
                                                <p class="align-middle w-full">{{$day->day}}</p>
                                            </div>
                                        </th>
                                    @endforeach                    
                                </tr>
                            </thead>
                            <tbody> 
                                @php
                                    $rowColCount = getTimetableRowColCount($classSchedule, $tables+1);
                                @endphp

                                @for ($row = 0; $row < $rowColCount['row']; $row++)
                                    <tr>
                                        @foreach ($rowColCount['col'] as $index => $day)

                                        @php
                                            $cellData = getCellData($classSchedule, $tables+1, $row+1, $day->id);
                                        @endphp

                                        @if($index == 0)
                                            <td class="td-container">
                                                <div class="flex flex-row gap-2 rounded-lg bg-gray-100 ring-1 ring-project-gray-default items-center justify-center">
                                                    <p class="bg-transparent text-center py-8">{{$cellData->time_start}}</p>
                                                    <p>-</p>
                                                    <p class="bg-transparent text-center py-8">{{$cellData->time_end}}</p>
                                                </div>
                                            </td>
                                        @endif
                                        {{-- @dd($cellData) --}}
                                        
                                        <td data-classroomId="{{$cellData->classroom_id}}"
                                            data-timetable="{{$cellData->timetable}}" 
                                            data-dayId="{{$cellData->day_id}}" 
                                            data-periodslot="{{$cellData->period_slot}}" 
                                            data-timeStart="{{$cellData->time_start}}" 
                                            data-timeEnd="{{$cellData->time_end}}" 

                                            data-subjectId="{{$cellData->subject_id}}" 
                                            data-subjectName="{{$cellData->subject_name}}" 
                                            data-defaultSubjectId="{{$cellData->default_subject_id}}" 
                                            data-subjectTypeId="{{$cellData->subject_type_id}}" 
                                            
                                            data-subjectTeacherId="{{$cellData->subject_teacher_id}}" 
                                            data-teacherId="{{$cellData->teacher_id}}" 
                                            data-honorific="{{$cellData->honorific}}" 
                                            data-firstName="{{$cellData->first_name}}" 
                                            data-lastName="{{$cellData->last_name}}" 
                                            
                                            
                                            class="td-container" aria-colindex="{{$day->id}}">
                                            <div class="flex flex-col justify-start items-start h-full bg-gray-100 rounded-lg ring-1 ring-project-gray-default">

                                                <x-subject-select fetchedSubjectId="{{$cellData->subject_id}}" fetchedSubject="{{$cellData->subject_name}}">

                                                    <div class="flex flex-col gap-2 p-3">
                                                        <p class="bg-project-primary text-project-accent">Academic Subjects</p>

                                                        @foreach ($subjects->filter(fn($val) => $val->defaultSubject->subject_type_id == 1) as $subject)
                                                        <div class="subject bg-project-primary text-white hover:bg-project-gray-dark" 
                                                            data-id="{{$subject->id}}" 
                                                            data-defaultSubjectId="{{$subject->default_subject_id}}" 
                                                            data-subjectTypeId="{{$subject->defaultSubject->subject_type_id}}" 
                                                            data-content="{{$subject->subject_name}}"
                                                            data-subjectTeacherId="{{$subject->subject_teacher_id}}"
                                                            >

                                                            <div class="flex flex-col">
                                                                <p>{{$subject->subject_name}}</p>
                                                                <p class="sp text-xs">sp: {{$subject->sp_frequency}}</p>
                                                                <p class="dp text-xs">dp: {{$subject->dp_frequency}}</p>
                                                            </div>
                                                            
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="flex flex-col gap-2">
                                                        <p class="bg-project-primary text-project-accent">Non-Academic Subjects</p>
                                                        @foreach ($subjects->filter(fn($val) => $val->defaultSubject->subject_type_id == 2) as $subject)
                                                        <div class="subject bg-project-primary text-white hover:bg-project-gray-dark" 
                                                            data-id="{{$subject->id}}"
                                                            data-defaultSubjectId="{{$subject->default_subject_id}}" 
                                                            data-subjectTypeId="{{$subject->defaultSubject->subject_type_id}}" 
                                                            data-content="{{$subject->subject_name}}"
                                                            data-subjectTeacherId="{{$subject->subject_teacher_id}}"
                                                            >
                                                            <p>{{$subject->subject_name}}</p>
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="flex flex-col gap-2">
                                                        <p class="bg-project-primary text-project-accent">Breaks</p>
                                                        @foreach ($subjects->filter(fn($val) => $val->defaultSubject->subject_type_id == 3) as $subject)
                                                        <div class="subject whitespace-nowrap bg-project-primary text-white hover:bg-project-gray-dark" 
                                                            data-id="{{$subject->id}}"
                                                            data-defaultSubjectId="{{$subject->default_subject_id}}" 
                                                            data-subjectTypeId="{{$subject->defaultSubject->subject_type_id}}" 
                                                            data-content="{{$subject->subject_name}}"
                                                            data-subjectTeacherId="{{$subject->subject_teacher_id}}"
                                                            
                                                            >
                                                            <p class="whitespace-nowrap">{{$subject->subject_name}}</p>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </x-subject-select>
                                                
                                                <x-teacher-select fetchedTeacherId="{{$cellData->teacher_id}}" fetchedTeacher="{{formatCellPersonName(collect($cellData))}}">
                                                    @foreach (getTeachersPerSubject($cellData->subject_id, $cellData->subject_type_id, $subjects) as $subjectTeacher)
                                                    
                                                        <div class="teacher whitespace-nowrap justify-start items-start bg-project-primary text-white hover:bg-project-gray-dark" 
                                                        data-id="{{$subjectTeacher->teacher->id}}"
                                                        data-content="{{formatCellPersonName(collect($subjectTeacher->teacher->user)->merge(collect($subjectTeacher->teacher->honorific)))}}"
                                                        data-subjectTeacherId="{{$subjectTeacher->id}}"
                                                        data-honorific="{{$subjectTeacher->teacher->honorific->honorific}}"
                                                        data-firstName="{{$subjectTeacher->teacher->user->first_name}}"
                                                        data-lastName="{{$subjectTeacher->teacher->user->last_name}}"
                                                        >
                                                        
                                                        <div class="flex flex-col p-3">
                                                                <p class="whitespace-nowrap">{{formatCellPersonName(collect($subjectTeacher->teacher->user)->merge(collect($subjectTeacher->teacher->honorific)))}}</p>
                                                                <p class="max-hours text-xs">Available for this day: {{$subjectTeacher->teacher->max_hours}}</p>
                                                                <p class="regular-load text-xs">Regular load: {{$subjectTeacher->teacher->regular_load}}</p>
                                                        </div>
                                                        </div>
                                                    @endforeach

                                                </x-teacher-select>
                                            </div>
                                        </td>

                                        @endforeach
                                    </tr>
                                @endfor
             
                            </tbody>
                        </table>

                    </div>
                @endfor
            @else
                <div class="flex">
                    <p>Select a section to view class schedule.</p>
                </div>
            @endif
            </div>
        </div>
    
    </x-main-layout>

    @vite('resources/js/class_schedule.js')
    

    