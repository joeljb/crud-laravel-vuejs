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
         "imagen" => "required|image",
         'imagen' => 'dimensions:min_width=300,min_height=300',
         'nombre_producto'=>"required|string|max:255",
         'descripcion_producto'=>"required|string|max:255",
         'precio'=>"required|numeric",
         'descuento'=>"required|numeric",
         'categoria_id'=>"required|integer",
      ];
    }
}
