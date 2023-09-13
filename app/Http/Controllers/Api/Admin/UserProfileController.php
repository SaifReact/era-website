<?php

namespace App\Http\Controllers\Api\Admin;

use App\Events\UserPasswordChanged;
use App\Events\UserUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Contracts\AuthContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UserProfileController
 * @package App\Http\Controllers\Api\Admin
 */
class UserProfileController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /** @var AuthContract */
    private $userService;

    /**
     * UserProfileController constructor.
     * @param UserRepository $userRepository
     * @param AuthContract $userService
     */
    public function __construct(UserRepository $userRepository, AuthContract $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        if(auth()->check()) {
            return response()->json([
                'status' => true,
                'message' => 'User profile showed!',
                'data' => auth()->user(),
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'message' => 'User profile can not be viewed!',
            'data' => null,
        ], Response::HTTP_OK);
    }

    /**
     * @param UserProfileRequest $request
     * @return JsonResponse
     */
    public function update(UserProfileRequest $request)
    {
        if(!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'User can not be updated!',
                'data' => null,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->userRepository->find(auth()->user()->id);
        $passwordFieldIsNotEmpty = $this->userService->passwordChanged($request);

        if($this->userRepository->update($user, $request->getParams())) {
            if(request()->post('send_notification')) {
                event(new UserUpdated($user->refresh()));
            }

            if($passwordFieldIsNotEmpty) {
                event(new UserPasswordChanged($user->refresh()));
            }

            auth()->guard('web')->logout();
            $request->session()->invalidate();

            return response()->json([
                'status' => true,
                'message' => 'User updated!',
                'data' => [
                    'ok' => true
                ],
            ], Response::HTTP_OK);
        }
    }
}
