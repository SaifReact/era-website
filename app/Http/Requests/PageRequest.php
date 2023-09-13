<?php

namespace App\Http\Requests;

use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Class PageRequest
 * @package App\Http\Requests
 */
class PageRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'max:150', 'unique:App\Models\Page,title'],
            'slug' => ['nullable', 'min:3', 'max:200', 'unique:App\Models\Page,slug'],
            'content' => ['required', 'min:3'],
            'meta' => ['nullable', 'min:3', 'max:100'],
        ];

        if ($this->isMethod(Request::METHOD_PUT) || $this->isMethod(Request::METHOD_PATCH) ) {
            $rules = array_merge($rules, [
                'title' => ['required', 'min:3', 'max:150', 'unique:App\Models\Page,title,'.$this->page->id],
                'slug' => ['nullable', 'min:3', 'max:200', 'unique:App\Models\Page,slug,'.$this->page->id],
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
                'slug' => SlugService::createSlug(Page::class, 'slug', $this->post('title')),
            ]);
        } else {
            if($this->post('title') !== $this->page->title) {
                return array_merge($this->post(), [
                    'slug' => SlugService::createSlug(Page::class, 'slug', $this->post('title')),
                ]);
            } else {
                return array_merge($this->post(), [
                    'slug' => !empty($this->post('slug')) ? $this->post('slug') : $this->page->slug,
                ]);
            }
        }
    }
}
