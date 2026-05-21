<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('segnalazioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dipendente_id')->nullable()->constrained('dipendenti')->nullOnDelete();
            $table->string('titolo');
            $table->text('descrizione');
            $table->string('stato')->default('aperta');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('segnalazioni');
    }
};