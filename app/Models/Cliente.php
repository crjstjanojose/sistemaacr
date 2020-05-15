<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{



    public function getNascimentoAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['nascimento']));
    }

    public function setNascimentoAttribute($value)
    {
        $date_parts = explode('/', $value);
        $this->attributes['nascimento'] = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
    }

}
