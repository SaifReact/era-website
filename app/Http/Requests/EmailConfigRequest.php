<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailConfigRequest extends FormRequest
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
            'active' => ['required', 'boolean'],
            'mailer' => ['required', 'min:3', 'max:100'],
            'host' => ['required', 'min:3', 'max:100'],
            'port'  => ['required', 'integer', 'min:0', 'max:10000'],
            'username' => ['required', 'min:3', 'max:100'],
            'password' => ['required', 'min:3', 'max:100'],
            'encryption' => ['required', 'min:3', 'max:100'],
            'from_address' => ['required', 'min:3', 'max:100'],
            'from_name' => ['nullable', 'min:3', 'max:100'],
        ];
    }
}
