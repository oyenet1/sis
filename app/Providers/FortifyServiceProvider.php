<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Builder;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // login view
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // Fortify::registerView(function () {
        //     return view('auth.register');
        // });

        // send password reset link
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forget-password');
        });
        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', compact('request'));
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // customized login
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('school_id', $request->school_id)
                ->orWhere('email', $request->school_id)
                ->orWhereRelation('guardian', 'parent_id', $request->school_id)
                ->orWhereRelation('guardian', 'email', $request->school_id)
                ->orWhereRelation('student', 'student_id', $request->school_id)
                ->orWhereRelation('student', 'email', $request->school_id)
                ->first();
            if (
                $user &&
                Hash::check($request->password, $user->password)
            ) {
                return $user;
            }
        });
    }
}