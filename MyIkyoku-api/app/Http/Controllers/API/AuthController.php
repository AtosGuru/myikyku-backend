<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Incorrect email address or password.'
            ], 401);

        $token = $this->getUserService()->generateToken($this->getAccount());
        return response()->json(array('token' => $token));
    }

    public function signup(SignupRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = $this->getUserService()->make([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => User::USER_ROLE_MEMBER,
            ]);

            $this->getUserProfileService()->make([
                'user_id' => $user->id,
                'name_sei' => $request->name_sei,
                'name_mei' => $request->name_mei
            ]);

            $token = $this->getUserService()->generateToken($user);

            DB::commit();

            return response()->json(array('token' => $token));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function logout()
    {
        $this->getAccount()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
