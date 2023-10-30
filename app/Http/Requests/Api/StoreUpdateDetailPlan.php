<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateDetailPlan extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Você deve inserir um Nome para o detalhe',
            'name.min' => 'O nome deve conter no mínimo 3 caracteres',
            'name.max' => 'O nome deve conter no máximo 255 caracteres',
        ];
    }
}
