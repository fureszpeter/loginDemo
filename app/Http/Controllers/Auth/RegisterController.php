<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Entities\User;
use App\Domain\Services\RegistrationService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * @var RegistrationService
     */
    private $registrationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RegistrationService $registrationService)
    {
        $this->middleware('guest');
        $this->registrationService = $registrationService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:\App\Domain\Entities\User,username'],
            'email' => ['required', 'string', 'email', 'max:255',
            'unique:\App\Domain\Entities\User,email',
            ],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): User
    {
        return $this->registrationService->register(
            $data['name'],
            $data['username'],
            $data['email'],
            $data['password']
        );
    }
}
