<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;
use App\Services\Contracts\AuthContract;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements AuthContract
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $arr
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function register(array $arr)
    {
        $arr['password'] = Hash::make($arr['password']);

        return $this->userRepository->create($arr);
    }

    /**
     * @param User $user
     * @return array
     */
    public function generateData(User $user): array
    {
        return $user->toArray();
        //return ['email' => $user->email];
    }

    public function check(User $user)
    {
        return (auth()->user()->id === $user->id);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function conditionalPassword(Request $request)
    {
        if($this->passwordChanged($request)) {
            return array_merge($request->post(), [
                'password' => Hash::make($request->post('password'))
            ]);
        }

        return $request->except('password');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function conditionalFields(Request $request)
    {
        $request->offsetUnset('email');

        return $this->conditionalPassword($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function passwordChanged(Request $request)
    {
        return ($request->post('password') != '');
    }
}
