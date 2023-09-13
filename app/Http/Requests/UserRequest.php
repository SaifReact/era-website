<?php

namespace App\Http\Requests;

use App\Enums\DateTimeFormat;
use App\Services\Contracts\AuthContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /** @var AuthContract */
    private $userService;

    /**
     * UserProfileRequest constructor.
     * @param AuthContract $userService
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(AuthContract $userService, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->userService = $userService;
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
    public function rules()
    {
        return [
            'name' => ['required', 'min:2', 'max:100', 'unique:App\Models\User,name,'.$this->user->id],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'photo' => ['nullable', 'url', 'min:14', 'max:191'],
            'first_name' => ['nullable', 'min:3', 'max:100'],
            'last_name' => ['nullable', 'min:3', 'max:100'],
            'send_notification' => ['nullable', 'boolean'],
            'remember_token' => ['nullable', 'min:3', 'max:100'],
        ];
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->userService->conditionalFields($this);
    }
}
