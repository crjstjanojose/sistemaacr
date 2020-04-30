<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = ['descricao','user_criacao'];

    protected $table = 'materiais';


    //protected $casts = ['created_at' => 'datetime:d/m/Y H:m:s',];


    public function getCreatedAtAttribute()
    {
        //return date('d/m/Y H:m', strtotime($this->attributes['created_at']));
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d/m/Y H:i:s');

    }

}
