<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfertaRequest extends FormRequest
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
            'id_producto' => 'required',
            'fecha_inicio' => 'required_with:fecha_termino|min:8',
            'fecha_termino' => 'required_with:fecha_inicio|mayor_que_el_campo:fecha_inicio',
            'precio_oferta' => 'required|alpha_num|min:0',
            'stock' => 'required|alpha_num|min:0',
        ];
    }
}
