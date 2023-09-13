<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ClientCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;

/**
 * Class ClientCategoryRequest
 * @package App\Http\Requests
 */
class ClientCategoryRequest extends FormRequest
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
            'category_name' => ['required', 'min:3', 'max:100', 'unique:App\Models\ClientCategory,category_name'],
            'slug' => ['nullable', 'min:3', 'max:150', 'unique:App\Models\ClientCategory,slug'],
            'order' => ['required', 'integer'],
        ];

        if ($this->isMethod(Request::METHOD_PUT) || $this->isMethod(Request::METHOD_PATCH) ) {
            $rules = array_merge($rules, [
                'category_name' => ['required', 'min:3', 'max:100', 'unique:App\Models\ClientCategory,category_name,'.$this->clientCategory->id],
                'slug' => ['nullable', 'min:3', 'max:150', 'unique:App\Models\ClientCategory,slug,'.$this->clientCategory->id],
            ]);
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        if ($this->isMethod(Request::METHOD_POST) ) {
            return array_merge($this->post(), [
                'slug' => SlugService::createSlug(ClientCategory::class, 'slug', $this->post('category_name')),
            ]);
        } else {
            if($this->post('category_name') !== $this->clientCategory->category_name) {
                return array_merge($this->post(), [
                    'slug' => SlugService::createSlug(ClientCategory::class, 'slug', $this->post('category_name')),
                ]);
            } else {
                return array_merge($this->post(), [
                    'slug' => !empty($this->post('slug')) ? $this->post('slug') : $this->clientCategory->slug,
                ]);
            }
        }
    }
}
