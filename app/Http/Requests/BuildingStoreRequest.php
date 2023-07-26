<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuildingStoreRequest extends FormRequest
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
            'name' => 'required|unique:buildings,name'
        ];
    }

    public function messages()
    {
        return[
            'name.unique' => 'Building name already exists.',
            'name.required' => 'Building name field name field cannot be blank.',
        ];
    }
}
