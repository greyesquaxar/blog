<?php

namespace App\Http\Controllers\moderador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchArticleController extends Controller
{
    public function index(Request $request)
    {
	    $miga='Buscador Artículos';
	    $busqueda=$request->busqueda;
	    $usuario=auth()->user();
	    $articulos=$usuario->articles()->withoutGlobalScope('activo')->with(['user','theme'])->where('titulo','like',"%$busqueda%")->orderBy('id','desc')->get();
	    return view('moderador.articulos.buscador')->with(compact('miga','articulos'));
	}
}
