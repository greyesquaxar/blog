<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class ArticleImage extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    protected $dates = ['deleted_at'];
    // $articleImagen->articulo
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
