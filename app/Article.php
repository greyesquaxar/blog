<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Article extends Model
{
    use TraductorFechas;
    use SoftDeletes;
    use SoftCascadeTrait;

    protected $dates = ['deleted_at'];
    protected $softCascade = ['images'];
    protected $fillable=['titulo','contenido','activo','theme_id'];

    // $article ->theme
    public function theme()
	{
		return $this->belongsTo(Theme::class);
	}

	// $article->user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // $articulo->imagenes
    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function imagenDestacada()
    {
        $imagenDestacada=$this->images->first();
        if(!$imagenDestacada)
            return 'sin_imagen.jpg';
        return $imagenDestacada->nombre;
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('activo', function ($query){
            return $query->where('activo',true);
        });
    }

    public function getEstaActivadoAttribute()
    {
        $estaActivado=$this->activo;
        if($estaActivado)
            return 'Si';
        return 'No';
    }

}
