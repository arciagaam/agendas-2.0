<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="New Template" />
        <x-page.actions>
            <x-button id="submit_schedule_template" label="Save" type="primary">
                <x-slot:icon>
                    <box-icon name='save'></box-icon>
                </x-slot:icon>
            </x-button>
        </x-page.actions>
    </div>

    <div class="grid grid-cols-8 gap-5 border border-project-gray-default bg-project-gray-light p-4 rounded-lg">
        <x-sections-dropdown label="Choose Section/s">
            @foreach ($sections as $section)
    
                <x-sections-selection gradeLevel="{{$section->gr_level}}">
                    @foreach ($section->classrooms as $classroom)
    
                        <div class="flex gap-2 pl-3 hover:bg-project-gray-default">
                            <input id="{{$classroom->section}}" type="checkbox" name="select_sections[]" class="select_sections" value="{{$classroom->id}}" data-section="{{$classroom->section}}">
                            <label class="w-full text-sm" for="{{$classroom->section}}">{{$classroom->section}}</label>
                        </div>
    
                    @endforeach
                </x-sections-selection>
    
            @endforeach
        </x-sections-dropdown>
        <div class="flex flex-col w-full gap-1 col-span-6">
            <p class="text-sm whitespace-nowrap">Selected <strong id="section_count" class="font-normal text-amber-500">0</strong> Section/s</p>
            <div id="selected_sections_container" class="flex flex-wrap gap-2">
                <p id="empty_text" class="pl-2 text-amber-500 text-sm">No selected sections yet.</p>
            </div>
        </div>
    </div>

    <div id="table_container" class="flex flex-wrap p-4 gap-5 border border-project-gray-default rounded-lg">
        <table data-tableNumber="1" class="table-auto border-separate border-spacing-2">
            <thead>
                <tr class="relative text-center">
                    <th>
                        <p class="absolute bottom-0 left-0 align-middle w-full">Time</p>
                    </th>
    
                    <th aria-colindex="1" class="h-20">
                        <div class="flex flex-col w-full p-5">
                            <x-timetable-selection/>
                            <p class="absolute bottom-0 left-0 align-middle w-full">Monday</p>
                        </div>
                    </th>
    
                    <th aria-colindex="2" class="h-20">
                        <div class="flex flex-col w-full p-5">
                            <x-timetable-selection/>
                            <p class="absolute bottom-0 left-0 align-middle w-full">Tuesday</p>
                        </div>
                    </th>
    
                    <th aria-colindex="3" class="h-20">
                        <div class="flex flex-col w-full p-5">
                            <x-timetable-selection/>
                            <p class="absolute bottom-0 left-0 align-middle w-full">Wednesday</p>
                        </div>
                    </th>
    
                    <th aria-colindex="4" class="h-20">
                        <div class="flex flex-col w-full p-5">
                            <x-timetable-selection/>
                            <p class="absolute bottom-0 left-0 align-middle w-full">Thursday</p>
                        </div>
                    </th>
                    
    
                    <th aria-colindex="5" class="h-20">
                        <div class="flex flex-col w-full p-5">
                            <x-timetable-selection/>
                            <p class="absolute bottom-0 left-0 align-middle w-full">Friday</p>
                        </div>
                    </th>
                    
                    <th class="header-actions"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td class="td-container gap-3">
                        <div class="td-content">
                            <input class="absolute top-0 left-0 h-1/2 w-full bg-transparent outline-0 cursor-pointer text-center" type="time" name="time_start[]">
                            <input class="absolute bottom-0 left-0 h-1/2 w-full bg-transparent outline-0 cursor-pointer text-center" type="time" name="time_end[]">
                        </div>
                    </td>
    
                    <td class="td-container" aria-colindex="1">
                        <div class="td-content">
                            <x-cell-type :types="$types"/>
                        </div>
                    </td>
    
                    <td class="td-container" aria-colindex="2">
                        <div class="td-content">
                            <x-cell-type :types="$types" />
                        </div>
                    </td>
    
                    <td class="td-container" aria-colindex="3">
                        <div class="td-content">
                            <x-cell-type :types="$types" />
                        </div>
                    </td>
    
                    <td class="td-container" aria-colindex="4">
                        <div class="td-content">
                            <x-cell-type :types="$types" />
                        </div>
                    </td>
    
                    <td class="td-container" aria-colindex="5">
                        <div class="td-content">
                            <x-cell-type :types="$types" />
                        </div>
                    </td>
    
                    <td class="body-actions">
                        <div class="flex gap-2">
                            <button type="button" class="remove-row ring-1 text-sm text-red-500 ring-project-gray-default hover:text-red-500 hover:ring-red-500 py-2 px-4 rounded-lg duration-200">-</button>
                            <button type="button" class="add-row ring-1 text-sm text-green-500 ring-project-gray-default hover:text-green-500 hover:ring-green-500 py-2 px-4 rounded-lg duration-200">+</button>
                        </div>
                    </td>
                </tr>
    
            </tbody>
        </table>
    </div>

</x-main-layout>

@vite('resources/js/schedule_template.js')