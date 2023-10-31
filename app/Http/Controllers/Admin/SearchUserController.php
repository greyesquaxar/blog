<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class SearchUserController extends Controller
{
    public function index(Request $request)
    {
    	$miga='Buscador de Usuarios';
    	$busqueda=$request->busqueda;
    	$usuariosBD=User::with('roles')->get();
    	if($busqueda=="moderadores")
    	{
	    	$usuarios=collect();
	    	foreach($usuariosBD as $usuario)
	    	{
	    		if($usuario->hasRole('moderador'))
	    			$usuarios->push($usuario);
	    	}
	    	return view('admin.usuarios.buscador')->with(compact('miga','usuarios'));
    	}

    	$usuarios=User::where('alias','like',"%$busqueda%")->orWhere('email','like',"%$busqueda%")->orWhere('name','like',"%$busqueda%")->get();
    	return view('admin.usuarios.buscador')->with(compact('miga','usuarios'));
    }
}
