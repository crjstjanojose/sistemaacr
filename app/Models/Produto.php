<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['codigo','denominacao','laboratorio_fornecedor','codigo_barra','preco'];


    public function encomendas()
    {
        return $this->hasMany('App\Models\Encomenda');
    }

    public function setPrecoAttribute($value)
    {
        $valor = str_replace(',', '.', $value);
        $this->attributes['preco'] = number_format($valor, 2, '.', ',');
    }

}
