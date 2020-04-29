<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Encomenda extends Model
{

    use SoftDeletes;

    protected $fillable = ['nome', 'contato', 'quantidade', 'preco', 'previsao', 'tipo_encomenda','produto_id',''];

    //protected $dateFormat = 'Y/m/d H:m:s';

    protected $dates = ['previsao','created_at'];

    protected $casts = ['created_at' => 'datetime:d/m/Y H:m:s',];


    public function getPrevisaoAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['previsao']));
    }

    public function setPrevisaoAttribute($value)
    {
        $date_parts = explode('/', $value);
        $this->attributes['previsao'] = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
    }

    public function getCreatedAtAttribute()
    {
        //return date('d/m/Y H:m', strtotime($this->attributes['created_at']));
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d/m/Y H:i:s');

    }

    public function setPrecoAttribute($value)
    {
        $valor = str_replace(',', '.', $value);
        $this->attributes['preco'] = number_format($valor, 2, '.', ',');
    }

    public function getPrecoAttribute()
    {
        return number_format($this->attributes['preco'], 2, ',', '.');
    }

    public function userCriacao()
    {
        return $this->hasOne('App\User', 'id', 'user_criacao');
    }

    public function userConfirmacao()
    {
        return $this->belongsTo('App\User', 'user_confirmacao', 'id');
    }

    public function userSolicitacao()
    {
        return $this->belongsTo('App\User', 'user_solicitacao', 'id');
    }

    public function userExclusao()
    {
        return $this->belongsTo('App\User', 'user_exclusao', 'id');
    }

    public function userAlteracao()
    {
        return $this->belongsTo('App\User', 'user_alteracao', 'id');
    }

    public function produto()
    {
        return $this->belongsTo('App\Models\Produto');
    }

    public function caracteristica()
    {
        return $this->belongsTo('App\Models\Caracteristica');
    }

}
