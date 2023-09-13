<?php

namespace App\Http\Requests;

use App\Enums\DateTimeFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * Class RegisterRequest
 * @package App\Http\Requests
 */
class RegisterRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'max:100', 'unique:App\Models\User,name'],
            'email' => ['required', 'email', 'min:8', 'max:100', 'unique:App\Models\User,email'],
            'email_verified_at' => ['nullable', 'date', 'date_format:'.DateTimeFormat::STORE],
            'password' => ['required', 'confirmed', Password::min(8)],
            'photo' => ['nullable', 'url', 'min:14', 'max:191'],
            'first_name' => ['nullable', 'min:3', 'max:100'],
            'last_name' => ['nullable', 'min:3', 'max:100'],
            'send_notification' => ['required', 'boolean'],
            'remember_token' => ['nullable', 'min:3', 'max:100'],
        ];
    }
}
