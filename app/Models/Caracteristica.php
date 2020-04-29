<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    public function encomendas()
    {
        return $this->hasMany('App\Models\Encomenda');
    }
}
