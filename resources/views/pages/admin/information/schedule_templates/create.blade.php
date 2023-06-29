<x-main-layout>

<label for="sap"> SAP</label>

    <select name="" id="sap">
        <option value="">tite</option>
    </select>

    <div class="flex gap-5">
        <x-sections-dropdown>
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
                        <div>
                            <x-cell-type />
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
