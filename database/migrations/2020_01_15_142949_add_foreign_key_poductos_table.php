<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyPoductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
   {
      Schema::table('productos', function (Blueprint $table) {
        
         $table->dropColumn('categoria_id');
               
      });
      Schema::table('productos', function (Blueprint $table) {
        
         $table->unsignedBigInteger('categoria_id');
         $table->foreign('categoria_id')
               ->references('id')->on('categorias');

      });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign('productos_categoria_id_foreign');
        });
    }
}
