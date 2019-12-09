<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        login as traitLogin;
        validateLogin as traitValidateLogin;
    }

    /** @var int */
    protected const MAX_FAILURE_BEFORE_CAPTCHA = 2;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(): string
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $attempts = $this->getAttempts($request);
        $request->session()->put(
            'captcha',
            [
                'maxAttempts' => self::MAX_FAILURE_BEFORE_CAPTCHA,
                'currentAttempts' => $attempts,
                'needToDisplay' => $this->isCaptchaAttemptsReached($request),
            ]
        );

        return $this->traitLogin($request);
    }

    protected function getAttempts(Request $request): int
    {
        return $this->limiter()->attempts($this->throttleKey($request));
    }

    protected function isCaptchaAttemptsReached(Request $request): bool
    {
        return $this->getAttempts($request) >= self::MAX_FAILURE_BEFORE_CAPTCHA;
    }

    protected function validateLogin(Request $request)
    {
        $this->traitValidateLogin($request);

        if ($this->isCaptchaAttemptsReached($request)) {
            $request->validate([
                recaptchaFieldName() => recaptchaRuleName(),
            ]);
        }
    }
}
