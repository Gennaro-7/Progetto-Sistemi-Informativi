<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ferie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dipendente_id')->nullable()->constrained('dipendenti')->nullOnDelete();
            $table->date('data_inizio');
            $table->date('data_fine');
            $table->text('motivo')->nullable();
            $table->string('stato')->default('in_attesa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ferie');
    }
};