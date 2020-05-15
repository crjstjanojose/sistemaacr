<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplicacao extends Model
{
    protected $table = 'aplicacoes';


    public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }

    public function userCriacao()
    {
        return $this->hasOne('App\User', 'id', 'user_criacao');
    }

    public function userAplicacao()
    {
        return $this->hasOne('App\User', 'id', 'user_aplicacao');
    }


    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente');
    }



    public function getDataVendaAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['data_venda']));
    }

    public function setDataVendaAttribute($value)
    {
        $date_parts = explode('/', $value);
        $this->attributes['data_venda'] = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
    }


    public function getDataAplicacaoAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['data_aplicacao']));
    }

    public function setDataAplicacaoAttribute($value)
    {
        $date_parts = explode('/', $value);
        $this->attributes['data_aplicacao'] = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
    }



}
