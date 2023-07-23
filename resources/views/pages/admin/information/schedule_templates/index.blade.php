<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Schedule Templates" />
        <x-page.actions>
            <x-anchor url="{{route('admin.information.schedule-templates.create')}}" label="Add Schedule Template" type="primary">
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

    @php
        $templates = [
            collect([
                'grade_level_id' => 3,
                'section' => 'Mars',
                'school_year' => '2022-2023',
            ]),

            collect([
                'grade_level_id' => 3,
                'section' => 'Jupiter',
                'school_year' => '2022-2023',
            ]),

            collect([
                'grade_level_id' => 3,
                'section' => 'Pluto',
                'school_year' => '2022-2023',
            ]),

            collect([
                'grade_level_id' => 3,
                'section' => 'Earth',
                'school_year' => '2022-2023',
            ]),
        ]
    @endphp

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Grade Level</x-table.td>
                <x-table.td :isHeader="true">Section</x-table.td>
                <x-table.td :isHeader="true">School Year</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($templates as $index => $template)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$template['grade_level_id']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$template['section']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$template['school_year']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last"></x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>