<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResourceInfoRequest
 * @package App\Http\Requests
 */
class ResourceInfoRequest extends FormRequest
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
            'commencement' => ['required', 'integer', 'min:0', 'max:100000'],
            'number_of_installation' => ['required', 'integer', 'min:0', 'max:100000'],
            'customers' => ['required', 'integer', 'min:0', 'max:100000'],
            'team_members' => ['required', 'integer', 'min:0', 'max:100000'],
        ];
    }
}
