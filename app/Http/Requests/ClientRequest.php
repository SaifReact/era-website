<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class ClientRequest
 * @package App\Http\Requests
 */
class ClientRequest extends FormRequest
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
            'logo' => ['required', 'url', 'min:14', 'max:191'],
            'client_category_id' => ['required', 'integer'],
            'client_name' => ['required', 'min:3', 'max:100'],
            'url' => ['nullable', 'url', 'min:14', 'max:200'],
            'order' => ['required', 'integer'],
        ];

        return $rules;
    }
}
