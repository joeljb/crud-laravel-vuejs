<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Categoria;

class CategoriaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      return Categoria::get();
    }
}
