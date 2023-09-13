<?php

namespace App\Http\Requests;

use App\Models\Menu;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class MenuRequest
 * @package App\Http\Requests
 */
class MenuRequest extends FormRequest
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
            'name' => ['required', 'min:2', 'max:50', 'unique:App\Models\Menu,name'],
            'order' => ['required', 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        if ($this->isMethod(Request::METHOD_POST) ) {
            return array_merge($this->post(), [
                'slug' => SlugService::createSlug(Menu::class, 'slug', $this->post('name')),
            ]);
        } else {
            if($this->post('name') !== $this->menu->name) {
                return array_merge($this->post(), [
                    'slug' => SlugService::createSlug(Menu::class, 'slug', $this->post('name')),
                ]);
            } else {
                return array_merge($this->post(), [
                    'slug' => !empty($this->post('slug')) ? $this->post('slug') : $this->menu->slug,
                ]);
            }
        }
    }
}
