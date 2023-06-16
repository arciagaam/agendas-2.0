<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Sections" />
        <x-page.actions>
            <x-button label="Add Section" type="primary">
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
        $sections = [
            collect([
                'grade_level' => 3,
                'section' => 'Mars',
            ]),

            collect([
                'grade_level' => 3,
                'section' => 'Jupiter',
            ]),

            collect([
                'grade_level' => 3,
                'section' => 'Pluto',
            ]),

            collect([
                'grade_level' => 3,
                'section' => 'Earth',
            ]),
        ]
    @endphp

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Grade Level</x-table.td>
                <x-table.td :isHeader="true">Section</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($sections as $index => $section)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$section['grade_level']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$section['section']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last"></x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>