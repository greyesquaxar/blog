<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Theme;
use Illuminate\Support\Facades\Storage;
use App\Jobs\BorrarTema;
use Illuminate\Validation\Rule;

class ThemeController extends Controller
{
    public function index()
    {
        $miga='Temas';
        $temas=Theme::with(['user'])->orderBy('id','desc')->get();
        return view('admin.temas.index')->with(compact('temas','miga'));
    }

    public function create()
    {
        $miga='Añadir Tema';
        return view('admin.temas.create')->with(compact('miga'));
    }

    public function store(Request $request)
    {
        $messages=[
            'nombre.required'=>'El campo Nombre no puede quedar vacío',
            'nombre.unique'=>'El nombre de este tema ya existe'
        ];
        
        $rules=[
            'nombre'=>'required|unique:themes'
        ];
        
        $destacado=$request->destacado;
        $suscripcion=$request->suscripcion;

        if($destacado && $suscripcion)
        {
            $notificacion2="Un tema de suscripción no puede estar en la pagina de inicio";
            return back()->with(compact('notificacion2')); 
        }

        $this->validate($request, $rules, $messages);

        $tema=new Theme($request->all());
        /*$tema->nombre=$request->nombre;
        $tema->destacado=$request->destacado;
        $tema->suscripcion=$request->suscripcion;*/
        $tema->user_id=auth()->user()->id; 
        $tema->slug=mb_strtolower((str_replace(" ","-",$request->nombre)),'UTF-8') ;
        $tema->save();
        $temaNombre = $tema->nombre;
        $notificacion="El tema $temaNombre se ha añadido correctamente";
        return back()->with(compact('notificacion'));
    }

    public function edit(Theme $tema)
    {
        $miga='Editar Tema';
        return view('admin.temas.edit')->with(compact('tema','miga'));
    }

    public function update(Request $request,Theme $tema)
    {
        $messages=[
            'nombre.required'=>'El campo Nombre no puede quedar vacío',
            'nombre.unique'=>'El nombre de este tema ya existe'
        ];
        $rules=[
            'nombre' => ['required',Rule::unique('themes')->ignore($tema->id)]
        ];
        
        $destacado=$request->destacado;
        $suscripcion=$request->suscripcion;

        if($destacado && $suscripcion)
        {
            $notificacion2="Un tema de suscripción no puede estar en la pagina de inicio";
            return back()->with(compact('notificacion2')); 
        }

        $this->validate($request, $rules, $messages);

        /*$tema->nombre=$request->nombre;
        $tema->destacado=$request->destacado;
        $tema->suscripcion=$request->suscripcion;
        $tema->save();*/
        $tema->update($request->all());
        $miga='Temas';
        $notificacion2='El tema se ha actualizado correctamente';
        return redirect('admin/temas')->with(compact('notificacion2','miga')); 

    }

    public function destroy(Theme $tema)
    {
        $tema->forceDelete();
        //BorrarTema::dispatch($tema);
        $notificacion="El tema se ha eliminado";
        return back()->with(compact('notificacion'));
    }

}
