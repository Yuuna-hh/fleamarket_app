<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user && method_exists($user, 'hasVerifiedEmail') && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        if ($user && property_exists($user, 'profile_completed') && ! $user->profile_completed) {
            return redirect('/mypage/profile');
        }

        return redirect()->intended('/');
    }
}
