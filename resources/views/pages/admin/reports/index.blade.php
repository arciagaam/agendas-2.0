<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Reports" />
        <x-page.actions>
            <x-button label="Print" type="primary">
                <x-slot:icon>
                    <box-icon name='plus-circle'></box-icon>
                </x-slot:icon>
            </x-button>
        </x-page>
    </div>

    <x-table.actions>

        <x-table.actions>
        
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
    
            <div class="form-input-container">
                <label class="text-sm" for="section">Section</label>
                
                <select class="form-input text-sm" name="section" id="section">
                    <option value={{null}}>Select Section</option>
                    <option value={{null}}>All Sections</option>
                    <option value="section_1">Section 1</option>
    
                </select>
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
    
    
        </x-table.actions>

    </x-table.actions>

    @php
        $buildings = [
            collect([
                'name' => 'San Lorenzo Ruiz',
                'room_count' => 10,
            ]),

            collect([
                'name' => 'St. Thomas Aquinas',
                'room_count' => 10,
            ]),

            collect([
                'name' => 'St. Dominic De Guzman',
                'room_count' => 10,
            ]),

            collect([
                'name' => 'St. Catherine Of Sienas',
                'room_count' => 10,
            ]),
        ]
    @endphp

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Building Name</x-table.td>
                <x-table.td :isHeader="true">Room Count</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($buildings as $index => $building)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$building['name']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$building['room_count']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last"></x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>