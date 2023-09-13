<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class BannerRequest
 * @package App\Http\Requests
 */
class BannerRequest extends FormRequest
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
            'banner_image' => ['required', 'url', 'min:14', 'max:191'],
            'banner_text' => ['nullable', 'min:3', 'max:100'],
            'button_text' => ['nullable', 'min:2', 'max:100'],
            'button_url' => ['nullable', 'url', 'min:14', 'max:200'],
            'order' => ['required', 'integer'],
        ];

        return $rules;
    }
}
