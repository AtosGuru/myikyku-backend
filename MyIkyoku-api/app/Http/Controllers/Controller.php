<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

use App\Services\UserService;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var UserService $userService */
    private $userService = null;

    /** @var User $account */
    private $account = null;

    public function getUserService()
    {
        if (!$this->userService) {
            $this->userService = resolve('App\Services\UserService');
        }

        return $this->userService;
    }

    public function getAccount()
    {
        if (!$this->account) {
            $this->account = Auth::user();
        }

        return $this->account;
    }

    public function getAccountId()
    {
        return $this->getAccount()->id;
    }
}
