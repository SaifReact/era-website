<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\UserPasswordChanged;
use App\Events\UserUpdated;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Contracts\AuthContract;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Class UsersController
 * @package App\Http\Controllers\Api\Admin
 */
class AuthController extends Controller
{
    /** @var UserRepository */
    private $userRepository;

    /** @var AuthContract */
    private $userService;

    /**
     * AuthController constructor.
     * @param UserRepository $userRepository
     * @param AuthContract $userService
     */
    public function __construct(UserRepository $userRepository, AuthContract $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!auth()->check() && !($user = auth()->user())) {
            if(auth()->attempt($request->getParams())) {
                $user = auth()->user();
                $data = $this->userService->generateData($user);
                $request->session()->regenerate();

                return response()->json([
                    'status' => true,
                    'message' => 'User is logged in!',
                    'data' => $data,
                ], Response::HTTP_OK);
            }

            return response()->json([
                'status' => false,
                'message' => 'Wrong user credentials!',
                'data' => null,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'message' => 'User is already logged in!',
            'data' => $this->userService->generateData(auth()->user()),
        ], Response::HTTP_OK);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => true,
                'message' => 'Please check your given email to reset password!',
                'data' => null,
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'message' => 'Your email is not in our database!',
            'data' => null,
        ], Response::HTTP_OK);
    }

    public function passwordReset($token, $email)
    {
        return view('web.admin.auth.password-reset', ['token' => $token, 'email' => $email]);
    }

    /**
     * @param PasswordResetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordResetPost(PasswordResetRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return ($status === Password::PASSWORD_RESET) ?
            redirect()->to('/admin#/auth/login')->with('status', __($status)) : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();

            return response()->json([
                'status' => true,
                'message' => 'User logged out!',
                'data' => null,
            ], Response::HTTP_OK);
        }

        $request->session()->invalidate();

        return response()->json([
            'status' => false,
            'message' => 'User is not logged in!',
            'data' => null,
        ], Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function update(User $user, UserRequest $request)
    {
        $currentUser = $this->userService->check($user);
        $passwordFieldIsNotEmpty = $this->userService->passwordChanged($request);

        if($this->userRepository->update($user, $request->getParams())) {
            if(request()->post('send_notification')) {
                event(new UserUpdated($user->refresh()));
            }

            if($passwordFieldIsNotEmpty) {
                event(new UserPasswordChanged($user->refresh()));
            }

            if(!$currentUser) {
                return response()->json([
                    'status' => true,
                    'message' => 'User updated!',
                    'data' => [
                        'ok' => true
                    ],
                ], Response::HTTP_OK);
            }

            auth()->guard('web')->logout();
            $request->session()->invalidate();

            return response()->json([
                'status' => true,
                'message' => 'User updated!',
                'data' => [
                    'ok' => false
                ],
            ], Response::HTTP_OK);
        }

        return response()->json([
            'status' => false,
            'message' => 'User can not be updated!',
            'data' => $user,
        ], Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(User $user, Request $request)
    {
        $currentUser = $this->userService->check($user);

        if(!$currentUser) {
            if($this->userRepository->delete($user)) {
                return response()->json([
                    'status' => true,
                    'message' => 'User deleted!',
                    'data' => [
                        'ok' => true
                    ],
                ], Response::HTTP_OK);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'User can not be deleted!',
            'data' => null,
        ], Response::HTTP_OK);
    }
}
