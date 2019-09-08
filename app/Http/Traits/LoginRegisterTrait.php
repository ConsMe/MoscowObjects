<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait LoginRegisterTrait
{
    public function getUserInfoWithToken(Request $request)
    {
        $user = $request->user()->user_info;
        return response(compact(['user']))->header('New-Token', csrf_token());
    }
}
