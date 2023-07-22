<x-main-layout>    
        <div class="flex flex-col gap-5">
            <x-table.actions>
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
            @if (request()->classroom_id && request()->grade_level_id)
                @for ($tables = 0; $tables < getTimetableCount($classSchedule); $tables++)

                    <div id="table_container" class="flex flex-wrap gap-5">
                        <table data-tableNumber="1" class="mt-12 table-auto border-separate border-spacing-2">
                            <thead>
                                <tr class="relative text-center">

                                    <th>Time</th>
                                    @foreach (getTimetableDays($classSchedule, $tables+1) as $day_id => $day)
                                        <th aria-colindex="{{$day->id}}">
                                            <div class="flex flex-col gap-5 w-full">
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
                                                <div class="flex flex-col gap-1 items-center justify-center">
                                                    <p>{{$cellData->time_start}}</p>
                                                    <p>{{$cellData->time_end}}</p>
                                                </div>
                                            </td>
                                        @endif
                                        
                                        <td data-subjectTeacherId="{{$cellData->subject_teacher_id}}" class="td-container" aria-colindex="{{$day->id}}">
                                            <div class="absolute inset-0 flex flex-col justify-center items-center h-full">
                                                {{-- {{$cellData->subject_name ?? 'Vacant'}} --}}
                                                @php
                                                    // $subjects = ['Math', 'Science', 'English'];
                                                    $teachers = ['Mr. Alberto Arciaga', 'Mr. Allen Padilla', 'Mr. Justine Valenzuela', 'Mr. Paul Caabay'];
                                                @endphp

                                                <x-subject-select fetchedSubjectId="{{$cellData->subject_id}}" fetchedSubject="{{$cellData->subject_name}}">

                                                    <div class="flex flex-col gap-2">
                                                        Academic Subjects
            
                                                        @foreach ($subjects->filter(fn($val) => $val->defaultSubject->subject_type_id == 1) as $subject)
                                                        <div class="subject" data-id="{{$subject->id}}" data-content="{{$subject->subject_name}}">
                                                            <p>{{$subject->subject_name}}</p>
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="flex flex-col gap-2">
                                                        Non-Academic Subjects
            
                                                        @foreach ($subjects->filter(fn($val) => $val->defaultSubject->subject_type_id == 2) as $subject)
                                                        <div class="subject" data-id="{{$subject->id}}" data-content="{{$subject->subject_name}}">
                                                            <p>{{$subject->subject_name}}</p>
                                                        </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="flex flex-col gap-2">
                                                        Breaks
            
                                                        @foreach ($subjects->filter(fn($val) => $val->defaultSubject->subject_type_id == 3) as $subject)
                                                        <div class="subject whitespace-nowrap" data-id="{{$subject->id}}" data-content="{{$subject->subject_name}}">
                                                            <p class="whitespace-nowrap">{{$subject->subject_name}}</p>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </x-subject-select>

                                                <x-teacher-select fetchedTeacherId="{{$cellData->teacher_id}}" fetchedTeacher="{{formatCellPersonName($cellData)}}">


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
    

    