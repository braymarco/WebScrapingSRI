<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rucs', function (Blueprint $table) {
            $table->id();
            $table->string("numero_ruc");
            $table->string("razon_social");
            $table->string("nombre_comercial");
            $table->string("estado_contribuyente");
            $table->string("clase_contribuyente");
            $table->string("fecha_inicio_actividades");
            $table->string("fecha_actualizacion");
            $table->string("fecha_suspension_definitiva");
            $table->string("fecha_reinicio_actividades");
            $table->string("obligado");
            $table->string("tipo_contribuyente");
            $table->string("numero_establecimiento");
            $table->string("nombre_fantasia_comercial");
            $table->string("estado_establecimiento");
            $table->string("descripcion_provincia");
            $table->string("descripcion_canton");
            $table->string("descripcion_parroquia");
            $table->string("codigo_ciiu");
            $table->text("actividad_economica");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rucs');
    }
};
