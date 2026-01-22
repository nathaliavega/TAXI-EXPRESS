<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('solicitudes_cambio_ruta', function (Blueprint $table) {
            // Agregar timestamps
            $table->timestamp('created_at')->nullable()->after('tarifa_cobrada');
            $table->timestamp('updated_at')->nullable()->after('created_at');
            
            // Hacer nullable campos que pueden no estar completos al crear
            $table->integer('id_tarifa_destino')->nullable()->change();
            $table->timestamp('fecha_viaje_programada')->nullable()->change();
            
            // Agregar estado si no existe
            if (!Schema::hasColumn('solicitudes_cambio_ruta', 'estado')) {
                $table->string('estado', 50)->default('pendiente')->after('updated_at');
            }
        });
    }

    public function down()
    {
        Schema::table('solicitudes_cambio_ruta', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
            
            if (Schema::hasColumn('solicitudes_cambio_ruta', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};