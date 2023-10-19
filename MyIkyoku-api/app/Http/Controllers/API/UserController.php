<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function find(Request $request)
    {
        $user = $this->getUserProfileService()->get($this->getAccount());
        return response()->json([
            'user' => $user
        ]);
    }
}
