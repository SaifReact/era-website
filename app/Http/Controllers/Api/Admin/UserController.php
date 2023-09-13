<?php

namespace App\Http\Controllers\Api\Admin;

use App\Events\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Contracts\AuthContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\Admin
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /** @var AuthContract */
    private $userService;

    /**
     * UserController constructor.
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
     * @return DataTableCollectionResource
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = $this->userRepository->eloquentQuery($sortBy, $orderBy, $searchValue)->where(['reserved' => false]);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        if ($user = $this->userService->register($request->post())) {
            if(request()->post('send_notification')) {
                event(new UserCreated($user->refresh()));
            }

            $data = $this->userService->generateData($user);

            return response()->json([
                'status' => true,
                'message' => 'User Registration is successful!',
                'data' => $data,
            ], Response::HTTP_CREATED);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function userInfo(Request $request)
    {
        if(auth()->check()) {
            return response()->json([
                'data' => auth()->user(),
            ]);
        }

        return response()->json([
           'data' => null,
        ]);
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => true,
            'message' => 'User showed!',
            'data' => $user,
        ], Response::HTTP_OK);
    }
}
