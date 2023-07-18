<x-main-layout>    
        <div class="flex gap-5">
            <div class="form-input-container">
                <label class="text-sm" for="grade_level_id">Grade Level</label>
                
                <select class="form-input text-sm" name="grade_level_id" id="grade_level_id">
                    <option value={{null}}>Select Grade Level</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="6">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>

            <x-sections-dropdown label="Choose Section/s">
                @foreach ($sections as $section)
        
                    <x-sections-selection gradeLevel="{{$section->gr_level}}">
                        @foreach ($section->classrooms as $classroom)
        
                            <div class="flex gap-2 pl-3">
                                <input type="checkbox" name="select_sections[]" class="select_sections" value="{{$classroom->id}}" data-section="{{$classroom->section}}">
                                <p>{{$classroom->section}}</p>
                            </div>
        
                        @endforeach
                    </x-sections-selection>
        
                @endforeach
            </x-sections-dropdown>
    
            <div id="selected_sections_container" class="flex flex-wrap">
                
            </div>
        </div>
    
        <div id="table_container" class="flex flex-wrap gap-5">
            <table data-tableNumber="1" class="mt-12 table-auto border-separate border-spacing-2">
                <thead>
                    <tr class="relative text-center">
                        <th>Time</th>
        
                        <th aria-colindex="1" class="">
                            <div class="flex flex-col gap-5 w-full">
                                <x-timetable-selection/>
                                <p class="align-middle w-full">Monday</p>
                            </div>
                        </th>
        
                        <th aria-colindex="2" class="">
                            <div class="flex flex-col gap-4">
                                <x-timetable-selection/>
                                <p>Tuesday</p>
                            </div>
                        </th>
        
                        <th aria-colindex="3" class="">
                            <div class="flex flex-col gap-4">
                                <x-timetable-selection/>
                                <p>Wednesday</p>
                            </div>
                        </th>
        
                        <th aria-colindex="4" class="">
                            <div class="flex flex-col gap-4">
                                <x-timetable-selection/>
                                <p>Thursday</p>
                            </div>
                        </th>
                        
        
                        <th aria-colindex="5" class="">
                            <div class="flex flex-col gap-4">
                                <x-timetable-selection/>
                                <p>Friday</p>
                            </div>
                        </th>
                        
                        <th class="header-actions"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td>
                            <div class="flex flex-col">
                                <input class="absolute top-0 left-0 h-1/2 w-full bg-transparent outline-0 cursor-pointer text-center" type="time" name="time_start[]">
                                <input class="absolute bottom-0 left-0 h-1/2 w-full bg-transparent outline-0 cursor-pointer text-center" type="time" name="time_end[]">
                            </div>
                        </td>
        
                        <td class="td-container" aria-colindex="1">
                            <div class="flex flex-col ">
                                <x-schedule-create-dropdown label="Select a Subject" class="w-full items-center justify-center flex-1">
                                    <x-subject-selection subjectType="Academic" class="h-fit">
                                        @foreach ($subjects as $index => $subject)
                            
                                            @if ($index == 5)
                                                @break
                                            @endif
                                
                                            <div class="flex gap-2 pl-3">
                                                {{-- <input type="checkbox" name="select_sections[]" class="select_sections" value="{{$subject->id}}" data-subject="{{$subject->id}}"> --}}
                                                <p data-type="academic" data-id="{{$subject->id}} "class="subject_data whitespace-nowrap">{{$subject->subject_name}}</p>
                                            </div>
                            
                                        @endforeach
                                    </x-subject-selection>
                            
                                    <x-subject-selection subjectType="Breaks">
                            
                            
                                    </x-subject-selection>
                            
                                    <x-subject-selection subjectType="Non-Academic">
                            
                            
                                    </x-subject-selection>
                                </x-schedule-create-dropdown>

                                <div data-type="" data-id="" class="teachers_dropdown hidden">
                                    <button class="teachers_dropdown_label flex items-center justify-center gap-2 w-full">
                                        <p class="whitespace-none teachers_dropdown_label_display">Select a Teacher</p>
                                        <box-icon name="chevron-down"></box-icon>
                                    </button>
                                
                                    <div aria-expanded="false" class="teachers_dropdown_body absolute top-[100%] left-0 overflow-y-hidden max-h-0 bg-red-50 z-50 aria-expanded:max-h-[100rem] transition-all">
                                        
                                    </div>
                                </div>
                            
                            </div>

                        </td>
        
                        <td class="td-container" aria-colindex="2">
                            <div>
                                <x-cell-type />
                            </div>
                        </td>
        
                        <td class="td-container" aria-colindex="3">
                            <div>
                                <x-cell-type />
                            </div>
                        </td>
        
                        <td class="td-container" aria-colindex="4">
                            <div>
                                <x-cell-type />
                            </div>
                        </td>
        
                        <td class="td-container" aria-colindex="5">
                            <div>
                                <x-cell-type />
                            </div>
                        </td>
        
                        <td class="body-actions">
                            <div class="flex gap-2">
                                <button type="button" class="remove-row bg-red-500 p-1 px-2">-</button>
                                <button type="button" class="add-row bg-green-500 p-1 px-2">+</button>
                            </div>
                        </td>
                    </tr>
        
                </tbody>
            </table>
        </div>
    
        <button id="submit_schedule_template">SAVE</button>
    
    
    </x-main-layout>
    
    @vite('resources/js/schedule_template.js')
    