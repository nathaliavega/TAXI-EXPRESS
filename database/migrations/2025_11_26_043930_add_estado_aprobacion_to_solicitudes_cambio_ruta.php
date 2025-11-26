<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('solicitudes_cambio_ruta', function (Blueprint $table) {
        if (!Schema::hasColumn('solicitudes_cambio_ruta', 'estado_aprobacion')) {
            $table->enum('estado_aprobacion', ['pendiente', 'aprobada', 'rechazada'])
                  ->default('pendiente')
                  ->after('fecha_autorizacion');
        }
    });
}

public function down()
{
    Schema::table('solicitudes_cambio_ruta', function (Blueprint $table) {
        $table->dropColumn('estado_aprobacion');
    });
}
};
