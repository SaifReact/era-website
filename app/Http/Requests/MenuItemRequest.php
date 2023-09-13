<?php

namespace App\Http\Requests;

use App\Enums\Target;
use App\Services\Contracts\MenuItemContract;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\MenuItemService;

/**
 * Class MenuItemRequest
 * @package App\Http\Requests
 */
class MenuItemRequest extends FormRequest
{
    /** @var MenuItemContract */
    private $menuItemService;

    /**
     * MenuItemRequest constructor.
     * @param MenuItemContract $menuItemService
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(MenuItemContract $menuItemService, array $query = [], array $request = [],
                                array $attributes = [], array $cookies = [], array $files = [], array $server = [],
                                $content = null)
    {
        $this->menuItemService = $menuItemService;

        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

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
            'name' => ['required', 'min:3', 'max:100'],
            'menu_id' => ['required', 'integer'],
            'page_id' => ['nullable', 'integer'],
            'external_url' => ['nullable', 'url', 'min:14', 'max:150'],
            'target' => ['required', 'min:3', 'max:15'],
        ];
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        if($this->menuItemService->isTargetEmpty($this->post())) {
            return array_merge($this->post(), [
                MenuItemService::TARGET_KEY => Target::SELF,
            ]);
        }

        return $this->post();
    }
}
