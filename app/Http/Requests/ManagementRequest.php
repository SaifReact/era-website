<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class ManagementRequest
 * @package App\Http\Requests
 */
class ManagementRequest extends FormRequest
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
        $rules = [
            'photo' => ['required', 'url', 'min:14', 'max:191'],
            'person_name' => ['required', 'min:3', 'max:100'],
            'designation' => ['required', 'min:3', 'max:100'],
            'message' => ['required', 'min:3', 'max:10000'],
            'url' => ['nullable', 'url', 'min:14', 'max:200'],
            'order' => ['required', 'integer'],
        ];

        return $rules;
    }
}
