<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            //'id' => 'required',
            'rut' => 'required',
            'nombres_razon_social' => 'required',
            //'apellidos' => 'required',
            //'giro' => 'required',
            'direccion' => 'required',
            'id_comuna' => 'required',
            'contacto' => 'required',            
        ];
    }
}
