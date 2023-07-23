<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectStoreRequest extends FormRequest
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
        if ($this->is_priority == '1') {
            $priority_validation = 'required';
        } else {
            $priority_validation = 'nullable';
        }
        return [
            'subject_code' => 'nullable',
            'subject_name' => 'nullable',
            'subject_description' => 'nullable',
            'default_subject_id' => 'required',
            'gr_level_id' => 'required',
            'sp_frequency' => 'required|min:0',
            'dp_frequency' => 'required|min:0',
            'is_priority' => 'required',
            'priority_time' => 'nullable|required_if:is_priority,1',
            'priority_day' => 'nullable|required_if:is_priority,1',
        ];
    }
}
