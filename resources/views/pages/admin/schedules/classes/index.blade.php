<x-main-layout>
    <div class="flex justify-between items-center">
        <x-page.header title="Class Schedules" />
        <x-page.actions>
            <x-button label="Add Building" type="primary">
                <x-slot:icon>
                    <box-icon name='plus-circle'></box-icon>
                </x-slot:icon>
            </x-button>

            <x-button label="Add Building" type="primary">
                <x-slot:icon>
                    <box-icon name='plus-circle'></box-icon>
                </x-slot:icon>
            </x-button>

            <x-button label="Add Building" type="primary">
                <x-slot:icon>
                    <box-icon name='plus-circle'></box-icon>
                </x-slot:icon>
            </x-button>

            <x-button label="Add Building" type="primary">
                <x-slot:icon>
                    <box-icon name='plus-circle'></box-icon>
                </x-slot:icon>
            </x-button>
        </x-page>
    </div>

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
                <option value="section_1">Section 1</option>

            </select>
        </div>


    </x-table.actions>
</x-main-layout>