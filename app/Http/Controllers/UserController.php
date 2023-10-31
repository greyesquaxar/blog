<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request)
    {
        $usuario=auth()->user();

        $messages=[
            'nombre.required' => 'Campo nombre requerido',
            'nombre.max' => 'Campo nombre demasiado largo',

            'alias.required' => 'Campo alias requerido',
            'alias.min' => 'Campo alias demasiado corto',
            'alias.max' => 'Campo alias demasiado largo',
            'alias.unique' => 'El alias ya existe en nuestra base de datos',

            'web.max' => 'Campo web demasiado largo',

            'password.required' => 'Campo password requerido',
            'password.regex' => 'La contraseña debe tener un minimo de 8 caracter y contener al menos una mayuscula, una minuscula y un número o caracter especial.'
        ];

        $rules=[
            'nombre' => 'required|string|max:190',
            /*'alias' => 'required|string|min:3|max:20|unique:users',*/
            'alias' => ['required','string','min:3',Rule::unique('users')->ignore($usuario->id)],
            'web' => 'max:20',
            'password' => array('required','string','regex:/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/') 
        ];

        $this->validate($request, $rules, $messages);

        
        $usuario->name=$request->nombre;
        $usuario->alias=$request->alias;
        $usuario->web=$request->web;
        $usuario->password=bcrypt($request->password);
        $usuario->update();
        $notificacion="Sus datos se han actualizado correctamente";
        return back()->with(compact('notificacion'));
    }
}
