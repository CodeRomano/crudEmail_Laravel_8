<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Country;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(){

        $countries = Country::all();
        return view('auth.register', ['countries' => $countries]);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[a-zA-Z0-9]*[@$!%*#?&.]/'],
            'phone_number' => ['nullable', 'string', 'min:8', 'max:10'],
            'num_doc_identity' => ['required', 'string', 'max:11'],
            'city_id' => ['required', 'exists:cities,id'],
            'flag_admin' => ['nullable', 'string'],
            'date_of_birth' => ['required', 'date', 'olderThan']
        ],
        [
            'password.regex' => __('validation.password_conditions'),
            'date_of_birth.olderThan' => __('validation.olderThan'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'num_doc_identity' => $data['num_doc_identity'],
            'city_id' => $data['city_id'],
            'flag_admin' => $data['flag_admin'],
            'date_of_birth' => date('Y-m-d', strtotime($data['date_of_birth']) )
        ]);
    }
}
