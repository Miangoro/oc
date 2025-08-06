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
        Schema::create('tickets_evidencia', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('ticket_id');
        $table->string('evidencia_url');
        $table->timestamps();

        $table->foreign('ticket_id')->references('id_ticket')->on('tickets')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_evidencias');
    }
};
