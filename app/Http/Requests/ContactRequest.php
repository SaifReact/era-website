<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'photo' => ['nullable', 'url', 'min:14', 'max:191'],
            'person_name' => ['nullable', 'min:3', 'max:100'],
            'designation' => ['nullable', 'min:3', 'max:100'],
            'contact_no' => ['required', 'min:10', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'primary_contact' => ['nullable', 'boolean'],
            'order' => ['required', 'integer'],
        ];
    }
}
