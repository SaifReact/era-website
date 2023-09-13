<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'min:8', 'max:100'],
            'password' => ['required', Password::min(8)],
        ];
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'email' => $this->post('email'),
            'password' => $this->post('password'),
        ];
    }
}
