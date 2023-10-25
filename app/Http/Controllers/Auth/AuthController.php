<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(StoreUserRequest $request)
    {
        try {
            $request->validated($request->all());

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return $this->success(['user' => $user, 'token' => $user->createToken('API Token of' . $user->name)->plainTextToken], 'Register successfully...');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $validator = $request->validated($request->all());
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    $token = $user->createToken('API Token of' . $user->name)->plainTextToken;
                    return $this->success([
                        'user' => $user,
                        'token' => $user->createToken('API Token of' . $user->name)->plainTextToken
                    ], 'Successfully login...');
                } else {
                    return $this->error('', 'Password mismatch', 401);
                }
            } else {
                return $this->error('', 'User does not exist', 401);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function logout(Request $request)
    {
        try {
            $userLogout =  $request->user()->currentAccessToken()->delete();
            if ($userLogout) {
                return $this->success('Logout successfully...');
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }
}
