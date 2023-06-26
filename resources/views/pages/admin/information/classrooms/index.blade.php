<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Classroom" />
        <x-page.actions>
            <x-anchor url="{{route('admin.information.classrooms.create')}}" label="Add Classroom" type="primary">
                <x-slot:icon>
                    <box-icon name='plus-circle'></box-icon>
                </x-slot:icon>
            </x-anchor>
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


    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Grade Level</x-table.td>
                <x-table.td :isHeader="true">Section</x-table.td>
                <x-table.td :isHeader="true">Adviser</x-table.td>
                <x-table.td :isHeader="true">Room</x-table.td>
                <x-table.td :isHeader="true">Building</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($classrooms as $classroom)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$classroom->grade_level}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$classroom->section}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$classroom->adviser_id ?? 'N/A'}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$classroom->room}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$classroom->building}}</x-table.td>
                    <x-table.td :trPosition="$loop->last"></x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>