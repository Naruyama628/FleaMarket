<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(LoginResponseContract::class, function () {
            return new class implements LoginResponseContract {
                public function toResponse($request)
                {
                    $user = $request->user();

                    if (! $user->hasVerifiedEmail()) {
                        return redirect()->route('verification.notice');
                    }

                    if (!$user->profile) {
                        return redirect('/profile/edit');
                    }

                    return redirect('/');
                }
            };
        });

        $this->app->singleton(RegisterResponseContract::class, function () {
            return new class implements RegisterResponseContract {
                public function toResponse($request)
                {
                    $user = $request->user();

                    if (! $user->hasVerifiedEmail()) {
                        return redirect()->route('verification.notice');
                    }

                    if (! $user->profile) {
                        return redirect('/profile/edit');
                    }

                    return redirect('/');                }
            };
        });

        $this->app->singleton(VerifyEmailResponseContract::class, function () {
            return new class implements VerifyEmailResponseContract {
                public function toResponse($request)
                {
                    $user = $request->user();

                    if (! $user->profile) {
                        return redirect('/profile/edit');
                    }

                    return redirect('/');
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        Fortify::authenticateUsing(function (Request $request) {
            $loginRequest = new LoginRequest();

            \Validator::make(
                $request->all(),
                $loginRequest->rules(),
                $loginRequest->messages()
            )->validate();

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['ログイン情報が登録されていません'],
                ]);
            }

            return $user;
        });

    }
}

