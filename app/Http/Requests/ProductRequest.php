<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class ProductRequest
 * @package App\Http\Requests
 */
class ProductRequest extends FormRequest
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
            'logo' => ['nullable', 'url', 'min:14', 'max:191'],
            'product_name' => ['required', 'min:3', 'max:100'],
            'summary' => ['required', 'min:3', 'max:1000'],
            'url' => ['nullable', 'url', 'min:14', 'max:200'],
            'box_color' => ['required', 'min:7', 'max:40'],
            'order' => ['required', 'integer'],
        ];

        return $rules;
    }
}
