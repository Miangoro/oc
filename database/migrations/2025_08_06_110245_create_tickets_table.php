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
        Schema::create('tickets', function (Blueprint $table) {
        $table->id('id_ticket');
        $table->string('asunto');
        $table->enum('prioridad', ['alta', 'media', 'baja']);
        $table->text('mensaje');
        $table->enum('estatus', ['pendiente', 'cerrado'])->default('pendiente');
        $table->unsignedBigInteger('id_usuario');
        $table->timestamps();

        $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
