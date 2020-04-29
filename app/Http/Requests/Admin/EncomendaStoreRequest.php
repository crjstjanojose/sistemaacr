<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EncomendaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|min:3|max:255',
            'previsao' => 'required',
            'quantidade' => 'required|integer|min:1',
            'preco' => 'required',
            'caracteristica_id' => 'required',
            'tipo_encomenda' => 'required',
            'produto_id' => 'required|min:1'
        ];
    }
}
