<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProducto extends FormRequest
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
         'categoria_id' => 'required|integer',
         'nombre_producto' => 'required',
         'descripcion_producto' => 'required',
         'imagen' => 'required',
         'precio' => 'required|numeric',
         'descuento' => 'required|numeric',
      ];
    }
}
