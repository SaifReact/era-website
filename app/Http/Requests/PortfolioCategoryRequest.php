<?php

namespace App\Http\Requests;

use App\Models\PortfolioCategory;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class PortfolioCategory
 * @package App\Http\Requests
 */
class PortfolioCategoryRequest extends FormRequest
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
            'category_name' => ['required', 'min:3', 'max:100', 'unique:App\Models\PortfolioCategory,category_name'],
            'slug' => ['nullable', 'min:3', 'max:150', 'unique:App\Models\PortfolioCategory,slug'],
            'order' => ['required', 'integer'],
        ];

        if ($this->isMethod(Request::METHOD_PUT) || $this->isMethod(Request::METHOD_PATCH) ) {
            $rules = array_merge($rules, [
                'category_name' => ['required', 'min:3', 'max:100', 'unique:App\Models\PortfolioCategory,category_name,'.$this->portfolioCategory->id],
                'slug' => ['nullable', 'min:3', 'max:150', 'unique:App\Models\PortfolioCategory,slug,'.$this->portfolioCategory->id],
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
                'slug' => SlugService::createSlug(PortfolioCategory::class, 'slug', $this->post('category_name')),
            ]);
        } else {
            if($this->post('category_name') !== $this->portfolioCategory->category_name) {
                return array_merge($this->post(), [
                    'slug' => SlugService::createSlug(PortfolioCategory::class, 'slug', $this->post('category_name')),
                ]);
            } else {
                return array_merge($this->post(), [
                    'slug' => !empty($this->post('slug')) ? $this->post('slug') : $this->portfolioCategory->slug,
                ]);
            }
        }
    }
}
