<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Subjects" />
        <x-page.actions>

            <x-button label="Upload CSV" type="secondary">
                <x-slot:icon>
                    <box-icon name='upload'></box-icon>
                </x-slot:icon>
            </x-button>

            <x-anchor url="{{route('admin.information.subjects.create')}}" label="Add Subject" type="primary">
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

        <div class="form-input-container">
            <label class="text-sm" for="gr_level_id">Grade level</label>

            <select class="form-input" name="gr_level_id" id="gr_level_id" onchange="this.form.submit()">
                @foreach ($grade_levels as $grade_level)
                    <option value="{{ $grade_level->id }}" @if ($grade_level->id == $subjects[0]->gr_level_id) selected @endif>{{ $grade_level->gr_level }}</option>
                @endforeach
            </select>
        </div>

    </x-table.actions>

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Subject</x-table.td>
                <x-table.td :isHeader="true">Code</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($subjects as $index => $subject)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$subject['subject_name']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$subject['subject_code']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">
                        <x-page.actions>
                            <x-anchor label="Edit" type="tertiary" size="none" url="{{route('admin.information.subjects.edit', ['subject' => $subject->id])}}">
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