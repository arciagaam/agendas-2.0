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

    </x-table.actions>

    @php
        $classrooms = [
            collect([
                'subject_name' => 'Math 1',
                'subject_code' => 'MATH-1',
                'grade_level' => '1',
                'assigned_teachers' => 'Teacher 1',
            ]),

            collect([
                'subject_name' => 'English 1 ',
                'subject_code' => 'ENG-1',
                'grade_level' => '1',
                'assigned_teachers' => 'Teacher 2',
            ]),

            collect([
                'subject_name' => 'Science 1',
                'subject_code' => 'SCI-1',
                'grade_level' => '1',
                'assigned_teachers' => 'Teacher 3',
            ]),

            collect([
                'subject_name' => 'Filipino 1',
                'subject_code' => 'FIL-1',
                'grade_level' => '1',
                'assigned_teachers' => 'Teacher 4',
            ]),
        ]
    @endphp

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Subject Name</x-table.td>
                <x-table.td :isHeader="true">Subject Code</x-table.td>
                <x-table.td :isHeader="true">Grade Level</x-table.td>
                <x-table.td :isHeader="true">Assigned Teachers</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($classrooms as $index => $classroom)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$classroom['subject_name']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$classroom['subject_code']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$classroom['grade_level']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$classroom['assigned_teachers']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last"></x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>