<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteUpdateRequest extends FormRequest
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
            'endereco' => 'required|min:3|max:255',
            'bairro' => 'required|min:3|max:255',
            'celular' => 'required|min:3|max:20|celular_com_ddd',
            'telefone' => 'max:20',
            'rg' => 'required|min:3|max:11',
            'cpf' => 'required|min:3|max:11|cpf',
            'nascimento' => 'required|date_format:d/m/Y',
            'cpf' => [
                'required', 'cpf',
                Rule::unique('clientes', 'cpf')->ignore($this->cliente)
            ],
        ];
    }
}
