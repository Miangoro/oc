<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes_eliminadas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_solicitud'); // ID de la solicitud eliminada
            $table->string('motivo')->nullable(); // Motivo de la eliminación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_eliminadas');
    }
};
