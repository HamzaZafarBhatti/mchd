<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Project;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            //            'avatar' => ['image' ,'mimes:jpg,jpeg,png','max:1024'],
            'department_code' => ['required'],
        ], [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute already exists.',
            'min' => 'The length of :attribute is :min at least.',
            'email' => 'The :attribute is not validation.',
            'image' => 'The :attribute is not valid image',
            'mimes' => 'The :attribute are available with jpg,jpeg and png',
            'confirmed' => 'Password should match the Confirm Password',
            'alpha' => 'The :attribute must be entirely alphabetic characters.',
            'regex' => 'Please enter a valid full name',
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
        // return request()->file('avatar');
        if (request()->has('avatar')) {
            $avatar = request()->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
        }

        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'avatar' => "user_default.jpg",
            'department_code' => $data['department_code'],
        ]);

        if ($user) {
            Notification::create([
                'message' => 'A new user "' . $user->name . '" Registered to "' . $user->department->name . '" Department',
            ]);
        }

        return $user;
    }
}
