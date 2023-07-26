<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Teachers" />
        <x-page.actions>

            <x-button label="Upload CSV" type="secondary">
                <x-slot:icon>
                    <box-icon name='upload'></box-icon>
                </x-slot:icon>
            </x-button>

            <x-anchor url="{{route('admin.information.teachers.create')}}" label="Add Teacher" type="primary">
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

            @php
                $rowValues = [10,20,30,40,50,75];
            @endphp
            
            <select class="form-input text-sm" name="rows" id="rows" onchange="this.form.submit()">
                @foreach ($rowValues as $rowValue)
                    <option value="{{$rowValue}}" @if ($rowValue == count($teachers)) selected @endif>{{$rowValue}}</option>
                @endforeach
            </select>
        </div>

    </x-table.actions>

    {{-- @php
        $teachers = [
            collect([
                'full_name' => 'Allen Padilla',
                'specializations' => 'Mars',
            ]),

            collect([
                'full_name' => 'Miguel Arciaga',
                'specializations' => 'Jupiter',
            ]),

            collect([
                'full_name' => 'Paul Caabay',
                'specializations' => 'Pluto',
            ]),

            collect([
                'full_name' => 'Justine Valenzuela',
                'specializations' => 'Earth',
            ]),
        ]
    @endphp --}}

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Full Name</x-table.td>
                <x-table.td :isHeader="true">Specialization</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($teachers as $index => $teacher)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$teacher['honorific'].' '.$teacher['first_name'].' '.$teacher['last_name']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$teacher['max_hours']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">
                        <x-page.actions>
                            <x-anchor label="Edit" type="tertiary" size="none" url="{{route('admin.information.teachers.edit', ['teacher' => $teacher['teacher_id']])}}">
                                <x-slot:icon>
                                    <box-icon name='edit'></box-icon>
                                </x-slot:icon>
                            </x-anchor>
                        </x-page.actions>
                    </x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>