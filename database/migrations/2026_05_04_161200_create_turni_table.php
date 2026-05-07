<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turni', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('turno');
           $table->foreignId('dipendente_id')->nullable()->constrained('dipendenti')->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turni');
    }
};