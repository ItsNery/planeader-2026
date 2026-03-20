<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubcomiteIdToDocumentossubcomitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentossubcomites', function (Blueprint $table) {
            // Agregar el campo de clave foránea
            $table->foreignId('subcomite_id')->constrained('subcomites')->onDelete('cascade');
            
            // Si deseas agregar restricciones adicionales, puedes hacerlo aquí
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documentossubcomites', function (Blueprint $table) {
            // Eliminar la restricción de clave foránea
            $table->dropForeign(['subcomite_id']);
            
            // Eliminar el campo de clave foránea
            $table->dropColumn('subcomite_id');
        });
    }
}
