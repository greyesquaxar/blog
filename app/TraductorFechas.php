<?php

namespace App;
use Jenssegers\Date\Date;

trait TraductorFechas
{
    public function getCreatedAtAttribute($fecha)
    {
        return new Date($fecha);
    }

    public function getDeletedAtAttribute($fecha)
    {
        return new Date($fecha);
    }

}