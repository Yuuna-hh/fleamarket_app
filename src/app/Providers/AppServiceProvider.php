<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse;
use App\Http\Responses\RegisterResponse as CustomRegisterResponse;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use App\Http\Responses\VerifyEmailResponse as CustomVerifyEmailResponse;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RegisterResponse::class, CustomRegisterResponse::class);
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
        $this->app->singleton(VerifyEmailResponse::class, CustomVerifyEmailResponse::class);
    }

    public function boot(): void
    {
        //
    }
}
