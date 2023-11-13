<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\Storage;
use App\SliderImage;

class SliderController extends Controller
{
    
    public function index()
    {
        $miga='Slider';
        return view('admin.slider')->with(compact('miga'));
    }

    public function store(Request $request)
    {
        $path=$request->file('file')->store('public/imagenesSlider');
        $nombreImagen = collect(explode('/', $path))->last();
        $extensionImagen = collect(explode('.', $path))->last();
        $imagen = Image::make(Storage::get($path));
        $imagen->resize(1920,1080);
        Storage::put($path,$imagen->encode($extensionImagen, 75));
        $imagen=new SliderImage();
        $imagen->nombre = $nombreImagen;
        // Agregamos el orden de la nueva imagen
        $posicionFinal=SliderImage::max('orden');
        if(is_null($posicionFinal))
        {
            $orden=1;
        }else{
            $orden=($posicionFinal)+1;
        }
        //
        $imagen->orden=$orden;
        $imagen->save(); 
    }

    public function destroy($id)
    {
        $imagen=SliderImage::findOrFail($id);
        Storage::disk('public')->delete('/imagenesSlider/'.$imagen->nombre);
        $imagen->delete();
    }

    public function imagenesMostrarAxios()
    {
        $imagenes=SliderImage::all();
        foreach($imagenes->sortBy('orden') as $imagen)
        {          
            echo    '<div style="cursor:move;border: solid 1px; margin-top: 2px; padding: 0" class="col-xs-6 col-xs-offset-3 imagen" id="'.$imagen->orden.'">
                        <img class="mover" width="100px" src="'.Storage::url('imagenesSlider/'.$imagen->nombre).'">
                        <img style="cursor: pointer; float: right; margin: 8px 8px 0px 0px" width="20px" onclick="eliminarImagen('.$imagen->id.')" src="'.asset('imagenes/admin/eliminar.png').'">
                    </div>';
        }
    }


}
