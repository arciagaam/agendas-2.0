<x-main-layout>



    <div id="table_container" class="flex flex-wrap gap-5">
        <table data-tableNumber="1" class="w-fit border-separate border-spacing-2">
            <thead>
                <tr class="text-center">
                    <th>Time</th>
    
                    <th aria-colindex="1">
                        <div class="flex flex-col gap-2">
                            <x-timetable-selection/>
                            <p>Monday</p>
                        </div>
                    </th>
    
                    <th aria-colindex="2">
                        <div class="flex flex-col gap-2">
                            <x-timetable-selection/>
                            <p>Tuesday</p>
                        </div>
                    </th>
    
                    <th aria-colindex="3">
                        <div class="flex flex-col gap-2">
                            <x-timetable-selection/>
                            <p>Wednesday</p>
                        </div>
                    </th>
    
                    <th aria-colindex="4">
                        <div class="flex flex-col gap-2">
                            <x-timetable-selection/>
                            <p>Thursday</p>
                        </div>
                    </th>
                    
    
                    <th aria-colindex="5">
                        <div class="flex flex-col gap-2">
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
                        <div class="flex flex-col gap-2">
                            <input type="time" name="time_start[]">
                            <input type="time" name="time_end[]">
                        </div>
                    </td>
    
                    <td aria-colindex="1">
                        <div>
                            <x-cell-type />
                        </div>
                    </td>
    
                    <td aria-colindex="2">
                        <div>
                            <x-cell-type />
                        </div>
                    </td>
    
                    <td aria-colindex="3">
                        <div>
                            <x-cell-type />
                        </div>
                    </td>
    
                    <td aria-colindex="4">
                        <div>
                            <x-cell-type />
                        </div>
                    </td>
    
                    <td aria-colindex="5">
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
