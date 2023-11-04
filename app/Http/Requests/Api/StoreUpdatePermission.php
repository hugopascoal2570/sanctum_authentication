<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdatePermission extends FormRequest
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
        $id = $this->segment(3);

        return [
            'name' => "required|min:3|max:255|unique:permissions,name,{$id},id",
            'description' => 'nullable|min:3|max:255',
        ];
    }

    public function messages()
    {

        return [
            'name.required' => 'Você deve inserir um Nome para a permissão',
            'name.unique' => 'O nome da permissão já está em uso',
            'name.min' => 'O nome deve conter no mínimo 3 caracteres',
            'name.max' => 'O nome deve conter no máximo 255 caracteres',
        ];
    }
}
