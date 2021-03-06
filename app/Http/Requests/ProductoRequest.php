<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'id' => 'required|alpha_num|min:0|unique:producto,id',//unique:producto'
            'nombre' => 'required',
            'descripcion' => 'required|max:1500',
            'precio_normal' => 'required|min:0',
            'stock' => 'required|alpha_num|min:0',
            'marca' => 'required',
            'modelo' => 'required',
            'id_categoria' => 'required',
            'id_subcategoria' => 'required'
        ];
    }
}
