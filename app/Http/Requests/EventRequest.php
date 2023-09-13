<?php

namespace App\Http\Requests;

use App\Enums\DateFormat;
use App\Enums\DateTimeFormat;
use App\Models\Event;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class EventRequest
 * @package App\Http\Requests
 */
class EventRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'max:100', 'unique:App\Models\Event,title'],
            'slug' => ['nullable', 'min:3', 'max:200', 'unique:App\Models\Event,slug'],
            'meta' => ['nullable', 'min:3', 'max:100'],
            'thumbnail' => ['required', 'url', 'min:14', 'max:191'],
            'image' => ['required', 'url', 'min:14', 'max:191'],
            'event_at' => ['required', 'date', 'date_format:'.DateFormat::STORE],
            /*'event_at' => ['required', 'date', 'date_format:'.DateFormat::STORE, 'before_or_equal:publish_at'],*/
            'teaser' => ['required', 'min:3', 'max:500'],
            'detail' => ['required', 'min:3'],
            'publish_at' => ['required', 'date', 'date_format:'.DateTimeFormat::STORE],
            /*'publish_at' => ['required', 'date', 'date_format:'.DateTimeFormat::STORE, 'after_or_equal:event_at'],*/
        ];

        if ($this->isMethod(Request::METHOD_PUT) || $this->isMethod(Request::METHOD_PATCH) ) {
            $rules = array_merge($rules, [
                'title' => ['required', 'min:3', 'max:100', 'unique:App\Models\Event,title,'.$this->event->id],
                'slug' => ['nullable', 'min:3', 'max:200', 'unique:App\Models\Event,slug,'.$this->event->id],
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
                'slug' => SlugService::createSlug(Event::class, 'slug', $this->post('title')),
            ]);
        } else {
            if($this->post('title') !== $this->event->title) {
                return array_merge($this->post(), [
                    'slug' => SlugService::createSlug(Event::class, 'slug', $this->post('title')),
                ]);
            } else {
                return array_merge($this->post(), [
                    'slug' => !empty($this->post('slug')) ? $this->post('slug') : $this->event->slug,
                ]);
            }
        }
    }
}
