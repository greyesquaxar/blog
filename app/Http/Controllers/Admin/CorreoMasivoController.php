<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Mail;
use App\Mail\CorreoMasivo;

class CorreoMasivoController extends Controller
{
    public function index()
    {
        $miga='Enviar Correos';
        return view('admin.correo-masivo')->with(compact('miga'));
    }

    public function correoMasivo(Request $request)
    {
        $messages=[
            'titulo.required'=>'El campo Asunto no puede quedar vacio',
            'contenido.required'=>'El campo Contenido no puede quedar vacio',
        ];
        $rules=[
            'titulo'=>'required',
            'contenido'=>'required',
        ];
        $this->validate($request, $rules, $messages);
        $asunto=$request->titulo;
        $contenido=$request->contenido;
        $usuarios=User::where('bloqueado',false)->whereNotNull('email_verified_at')->get();
        foreach ($usuarios as $usuario) {
        	// aquí vamos enviando los correos a cada usuario.
        	Mail::to($usuario)->send(new CorreoMasivo($usuario , $asunto , $contenido));
        }

        $notificacion="Se ha enviado correctamente el mensaje a todos los subscriptores";
        return back()->with(compact('notificacion'));
    }
}
