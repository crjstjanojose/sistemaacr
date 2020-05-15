<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AplicacaoUpdateRequest extends FormRequest
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
            'cliente_id' => 'required',
            'produto_id' => 'required',
            'user_aplicacao' => 'required',
            'data_aplicacao' => 'required|date_format:d/m/Y',
            'data_venda' => 'required|date_format:d/m/Y',
            'documento_fiscal' => 'required|integer|min:1'
        ];
    }
}
