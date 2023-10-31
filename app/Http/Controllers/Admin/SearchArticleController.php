<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Theme;
use App\User;

class SearchArticleController extends Controller
{
    public function index(Request $request)
    {
    	$miga='Buscador Artículos';
    	$busqueda=$request->busqueda;
    	$tema=Theme::where('nombre','like',"$busqueda")->first();
        $usuario=User::where('name','like',"$busqueda")->first();
        if($usuario)
        {
        	foreach($usuario->roles as $role)
            {
                if($role->nombre=="administrador" || $role->nombre=="moderador") 
                {
                    // preguntamos si el usuario tiene articulos. $provincias = Provincia::has('anexos')->get();
	        		$articulos=$usuario->articles()->withoutGlobalScope('activo')->with(['user','theme'])->orderBy('id','desc')->get();
	                return view('admin.articulos.buscador')->with(compact('miga','articulos'));
                }
            }
        }
    	
    	if($tema)
    	{

    		$articulos=$tema->articles()->withoutGlobalScope('activo')->with(['user','theme'])->orderBy('id','desc')->get();
			return view('admin.articulos.buscador')->with(compact('miga','articulos'));
    	}

    	$articulos=Article::withoutGlobalScope('activo')->with(['user','theme'])->where('titulo','like',"%$busqueda%")->orderBy('id','desc')->get();
    	return view('admin.articulos.buscador')->with(compact('miga','articulos'));
    }
}
