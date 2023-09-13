<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class TestimonialRequest
 * @package App\Http\Requests
 */
class TestimonialRequest extends FormRequest
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
            'client_name' => ['required', 'min:3', 'max:100'],
            'person_name' => ['nullable', 'min:3', 'max:100'],
            'designation' => ['nullable', 'min:3', 'max:100'],
            'message' => ['required', 'min:3', 'max:1000'],
            'order' => ['required', 'integer'],
        ];

        return $rules;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
    }
}
