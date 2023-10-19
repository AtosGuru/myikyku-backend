<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;

class UserProfileService
{
    public function make(Array $info)
    {
        $userProfile = new UserProfile($info);

        $userProfile->save();

        return $userProfile;
    }

    public function get(User $user)
    {
        $userProfile = $user->userProfile;
        return [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'name_sei' => $userProfile->name_sei,
            'name_mei' => $userProfile->name_mei,
        ];
    }
}
