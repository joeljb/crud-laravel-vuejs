<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{
   
   protected $table = "productos";

   protected $fillable = [
      'categoria_id','nombre_producto', 'descripcion_producto','imagen','precio','descuento'
   ];

   // public function categoria()
   // {
   //    return $this->belongsTo('App\Categoria');
   // }

    public function categoria()
   {
      return $this->belongsTo('App\Categoria')->withDefault();
   }

}
