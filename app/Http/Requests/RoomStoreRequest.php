<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->user_type_id == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:rooms,name,,id,building_id,' . $this->input('building_id'),
            'number' => 'nullable|numeric|unique:rooms,number,,id,building_id,' . $this->input('building_id'),
            'building_id' => 'required'
        ];
    }

    public function messages()
    {
        return[
            'name.required' => 'Room name field cannot be blank.',
            'name.unique' => 'Room '.$this->input('name').' already exists in the selected building.',
            'number.numeric' => 'Input must be numeric.',
            'number.unique' => 'Room Number '.$this->input('name').' already exists in the selected building.',
            'building_id.required' => 'Please select a building.',
        ];
    }
}
