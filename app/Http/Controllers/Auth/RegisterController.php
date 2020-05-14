<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Breeder;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'last_name'    => ['required', 'string', 'min:1', 'max:255'],
            'email'       => ['bail','required', 'string', 'email', 'max:255', 'unique:users'],
            'password'    => ['required', 'string', 'min:1', 'confirmed'],
            'first_name'   => ['required', 'string', 'min:1', 'max:255'],
            'department' => ['required', 'string', 'min:1', 'max:255'],
            'breeder_name'=> ['string', 'min:2', 'max:100'],
            'siret'       => ['nullable','string', 'min:14', 'max:14', 'unique:breeders'],
            'type_of_user'    => ['bail','required', 'integer', 'in:0,1'],
            'legal_conditions' => ['required','accepted'],
            'breeder_name' => Rule::requiredIf(function () use ($data) {
                return (isset($data['type_of_user']) && $data['type_of_user'] == "1");
            }),
            /*'siret' => Rule::requiredIf(function () use ($data) {
                return ($data['userType'] != "1");
            }),*/
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
        // add the user
        $user = new User();
        $user->last_name    = $data['last_name'];
        $user->first_name   = $data['first_name'];
        $user->email        = $data['email'];
        $user->department   = $data['department'];
        $user->password     = Hash::make($data['password']);
        $user->type_of_user = $data['type_of_user'];

        if(isset($data['type_of_user']) && $data['type_of_user'] == "1") {
            $user->siret       = $data['siret'];
            $user->breeder_name = $data['breeder_name'];
        }

        $user->save();

        return $user;

    }
}
