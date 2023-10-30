<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePlan extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $url = $this->segment(3);

        return [
            'name' => "required|min:3|max:255|unique:plans,name,{$url},url",
            'description' => 'nullable|min:3|max:255',
            'price' => "required|regex:/^\d+(\.\d{1,2})?$/",
        ];
    }
    public function messages()
    {

        return [
            'name.required' => 'Você deve inserir um Nome para o usuário',
            'name.min' => 'O nome deve conter no mínimo 3 caracteres',
            'name.max' => 'O nome deve conter no máximo 255 caracteres',
            'price.required' => 'Você deve inserir um preço para o plano',
        ];
    }
}
