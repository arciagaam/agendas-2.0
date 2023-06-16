<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Event Schedules" />
        <x-page.actions>
            <x-button label="Add Event" type="primary">
                <x-slot:icon>
                    <box-icon name='plus-circle'></box-icon>
                </x-slot:icon>
            </x-button>
        </x-page>
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


    </x-table.actions>

    @php
        $events = [
            collect([
                'name' => 'First Event',
                'section' => 'Grade 1',
            ]),

            collect([
                'name' => 'Second Event',
                'section' => 'Institutional',
            ]),

            collect([
                'name' => 'Third Event',
                'section' => 'Grade 2',
            ]),

            collect([
                'name' => 'Fourth Event',
                'section' => 'Grades 4, 5, and 6',
            ]),
        ]
    @endphp

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Event Name</x-table.td>
                <x-table.td :isHeader="true">Attendees</x-table.td>
                <x-table.td :isHeader="true">Date</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$event['name']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$event['section']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{now()}}</x-table.td>
                    <x-table.td :trPosition="$loop->last"></x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>