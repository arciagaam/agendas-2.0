<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Accounts" />
        <x-page.actions>

            <x-button label="Upload CSV" type="primary">
                <x-slot:icon>
                    <box-icon name='upload'></box-icon>
                </x-slot:icon>
            </x-button>

            <x-button label="Add Account" type="primary">
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
        $buildings = [
            collect([
                'username' => 'admin1',
                'email' => 'admin1@gmail.com',
                'full_name' => 'FirstName LastName',
                'role' => 'Super Admin',
                'assigned_classroom' => '',
            ]),

            collect([
                'username' => 'admin2',
                'email' => '',
                'full_name' => 'FirstName LastName',
                'role' => 'Super Admin',
                'assigned_classroom' => '',
            ]),

            collect([
                'username' => 'admin3',
                'email' => '',
                'full_name' => 'FirstName LastName',
                'role' => 'Super Admin',
                'assigned_classroom' => '',
            ]),

            collect([
                'username' => 'admin4',
                'email' => 'admin4@gmail.com',
                'full_name' => 'FirstName LastName',
                'role' => 'Super Admin',
                'assigned_classroom' => '',
            ]),
        ]
    @endphp

    <table class="border-separate border-spacing-0">
        <thead>
            <x-table.tr :isHeader="true">
                <x-table.td :isHeader="true">Username</x-table.td>
                <x-table.td :isHeader="true">Email</x-table.td>
                <x-table.td :isHeader="true">Full Name</x-table.td>
                <x-table.td :isHeader="true">Role</x-table.td>
                <x-table.td :isHeader="true">Assigned Classroom</x-table.td>
                <x-table.td :isHeader="true">Actions</x-table.td>
            </x-table.tr>
        </thead>
        <tbody>
            @foreach ($buildings as $index => $building)
                <tr>
                    <x-table.td :trPosition="$loop->last">{{$building['username']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$building['email']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$building['full_name']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$building['role']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last">{{$building['assigned_classroom']}}</x-table.td>
                    <x-table.td :trPosition="$loop->last"></x-table.td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-main-layout>