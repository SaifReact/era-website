<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class PortfolioRequest
 * @package App\Http\Requests
 */
class PortfolioRequest extends FormRequest
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
            'thumbnail' => ['required', 'url', 'min:14', 'max:191'],
            'image' => ['required', 'url', 'min:14', 'max:191'],
            'name' => ['required', 'min:3', 'max:100'],
            'portfolio_category_id' => ['required', 'integer'],
            'detail' => ['required', 'min:3'],
            'order' => ['required', 'integer'],
        ];

        return $rules;
    }
}
