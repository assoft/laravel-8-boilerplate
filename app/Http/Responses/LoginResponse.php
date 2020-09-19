<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {
        $redirect = config('fortify.home');

        $check = Auth::user()->hasAnyRole([
            "admin",
            "moderator",
            "author",
        ]);

        if ($check) {
            $redirect = route("admin.dashboard");
        }

        return redirect($redirect);
    }
}
