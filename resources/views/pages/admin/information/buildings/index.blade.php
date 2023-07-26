<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Buildings" />
        <x-page.actions>
            <x-anchor url="{{route('admin.information.buildings.create')}}" label="Add Building" type="primary">
                <x-slot:icon>
                    <box-icon name='plus-circle'></box-icon>
                </x-slot:icon>
            </x-anchor>
        </x-page.actions>
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
            
            <select class="form-input text-sm" name="rows" id="rows" onchange="this.form.submit()">
                <option value="10" {{request()->rows == 10 ? 'selected' : ''}}>10</option>
                <option value="20" {{request()->rows == 20 ? 'selected' : ''}}>20</option>
                <option value="30" {{request()->rows == 30 ? 'selected' : ''}}>30</option>
                <option value="40" {{request()->rows == 40 ? 'selected' : ''}}>40</option>
                <option value="50" {{request()->rows == 50 ? 'selected' : ''}}>50</option>
                <option value="75" {{request()->rows == 75 ? 'selected' : ''}}>75</option>
                <option value="100" {{request()->rows == 100 ? 'selected' : ''}}>100</option>
            </select>
        </div>

    </x-table.actions>

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Building Name</x-table.td>
                <x-table.td :isHeader="true">Room Count</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($buildings as $building)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$building->name}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$building->room_count ?? 'N/A'}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">
                        <x-page.actions>
                            <x-anchor label="Edit" type="tertiary" size="none" url="{{route('admin.information.buildings.edit', ['building' => $building->id])}}">
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