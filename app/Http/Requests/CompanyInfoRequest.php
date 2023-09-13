<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Class CompanyInfoRequest
 * @package App\Http\Requests
 */
class CompanyInfoRequest extends FormRequest
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
            'logo_src' => ['required', 'url', 'min:14', 'max:191'],
            'logo_small_src' => ['required', 'url', 'min:14', 'max:191'],
            'logo_alt' => ['required', 'min:3', 'max:50'],
            'root_url' => ['required', 'min:1', 'max:200'],
            'website_name' => ['required', 'min:3', 'max:50'],
            'tagline' => ['nullable', 'min:3', 'max:100'],
            'location' => ['nullable', 'min:3', 'max:150'],
            'map_location' => ['nullable', 'url', 'min:14', 'max:500'],
            'fax' => ['nullable', 'min:7', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'phone' => ['nullable', 'min:7', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'email' => ['nullable', 'email', 'min:8', 'max:100'],
            'web' => ['nullable', 'url', 'min:14', 'max:200'],
            'facebook' => ['nullable', 'url', 'min:14', 'max:200'],
            'linkedin' => ['nullable', 'url', 'min:14', 'max:200'],
            'company_summary' => ['nullable', 'min:10', 'max:1000'],
            'open_days' => ['nullable', 'min:5', 'max:100'],
            'duration' => ['nullable', 'min:5', 'max:50'],
        ];

        return $rules;
    }
}
