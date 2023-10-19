<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function make(Array $info)
    {
        $user = new User($info);

        $user->save();

        return $user;
    }

    public function generateToken(User $user)
    {
        $tokenResult = $user->createToken(env('APP_NAME', 'Laravel'));
        $token = $tokenResult->token;
        $token->save();

        return $tokenResult->accessToken;
    }
}
