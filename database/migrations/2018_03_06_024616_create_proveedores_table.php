<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
            * Nota: La tabla proovedores va hacer referencia a la tabla personas en el cual no vamos a tener un campo 
            * "increments" sino "integer" porque este valor que se va guardar en el campo id de la tabla proovedores va 
            * ser el mismo valor que se guarda en el campo id de la tabla personas.Y como sera una llave foranea le vamos 
            * a colocar la propiedad "unsigned"*/
        Schema::create('proveedores', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('contacto',50)->nullable();
            $table->string('telefono_contacto',50)->nullable(); 
            /**
             * No implementamos el campo timestamp(), porque para la tabla proovedores no implementaremos los
             * campos create_up y update_up
             */
            
            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade'); 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
