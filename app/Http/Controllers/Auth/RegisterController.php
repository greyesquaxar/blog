<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

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

    protected function registered(Request $request, $user)
    {
        $user->roles()->sync(1);
        return redirect($this->redirectPath());
    }

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
        /* Agregado por mi */
        $mensajes = array(
            'name.required' => 'Campo nombre requerido',
            'name.max' => 'Campo nombre demasiado largo',

            'email.required' => 'Campo email requerido',
            'email.max' => 'Campo email demasiado largo',
            'email.unique' => 'El email ya existe',
            'email.email' => 'El email debe ser válido',

            'alias.required' => 'Campo alias requerido',
            'alias.min' => 'Campo alias demasiado corto',
            'alias.max' => 'Campo alias demasiado largo',
            'alias.unique' => 'El alias ya existe',

            'web.max' => 'Campo web demasiado largo',

            'password.required' => 'Campo contraseña requerido',
            'password.confirmed' => 'Los campos de contraseña no coinciden',
            'password.regex' => 'La contraseña debe tener un minimo de 8 caracteres y contener al menos una mayuscula, 
                una miniscula y un caracter especial.',
        );
        /* Agregado por mi */

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],

            /* mio */
            'alias' => 'required|string|min:3|max:20|unique:users',
            'web' => 'max:20',
            /* mio */
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password' => array('required', 'string', 'confirmed', 'regex:/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/'),

        ],$mensajes);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'alias' => $data['alias'], //mio
            'web' => $data['web'], //mio
            'password' => Hash::make($data['password']),
        ]);
    }
}
