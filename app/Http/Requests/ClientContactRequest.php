<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ClientContactRequest
 * @package App\Http\Requests
 */
class ClientContactRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'max:100'],
            'email' => ['required', 'min:2', 'max:100'],
            'subject' => ['required', 'min:2', 'max:200'],
            'message' => ['required', 'min:2', 'max:1000'],
        ];
    }
}
