<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        /*$busqueda=$request->busqueda;
    	$articulos=Article::where('titulo','like',"%$busqueda%")->ArticulosActivos()->with(['images'])->orderBy('id','desc')->get();
        return view('buscador')->with(compact('articulos'));*/

        $articulosPermitidos=collect();
        $busqueda=$request->busqueda;
        if(auth()->check())
        {
            if(!is_null(auth()->user()->email_verified_at))
            {
                if(!auth()->user()->bloqueado)
                {
                    $articulos=Article::where('titulo','like',"%$busqueda%")->with(['images'])->orderBy('id','desc')->get();
                    return view('buscador')->with(compact('articulos'));
                }
                
                $articulos=Article::where('titulo','like',"%$busqueda%")->with(['images','theme'])->orderBy('id','desc')->get();
                foreach($articulos as $articulo)
                {
                    if(!$articulo->theme->suscripcion)
                        $articulosPermitidos->push($articulo);          
                }
                return view('buscador')->with(compact('articulosPermitidos'));
            }
            $articulos=Article::where('titulo','like',"%$busqueda%")->with(['images','theme'])->orderBy('id','desc')->get();
                foreach($articulos as $articulo)
                {
                    if(!$articulo->theme->suscripcion)
                        $articulosPermitidos->push($articulo);          
                }
                return view('buscador')->with(compact('articulosPermitidos'));
        }

        $articulos=Article::where('titulo','like',"%$busqueda%")->with(['images','theme'])->orderBy('id','desc')->get();
        foreach($articulos as $articulo)
        {
            if(!$articulo->theme->suscripcion)
                $articulosPermitidos->push($articulo);          
        }
        return view('buscador')->with(compact('articulosPermitidos'));
    }
}
