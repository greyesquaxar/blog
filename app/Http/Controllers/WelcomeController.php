<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;


class WelcomeController extends Controller
{
    public function welcome(){

        /* $temasTodos = DB::select('select * from themes'); */
        /* $temasTodos = DB::table('themes')->get(); */
        /*$temasTodos=Theme::all();*/

        $temasDestacados=Theme::where('destacado',1)->with(['articles.images'])->orderby('id','desc')->get();
        return view('welcome')->with(compact('temasDestacados'));
        
    }
}
