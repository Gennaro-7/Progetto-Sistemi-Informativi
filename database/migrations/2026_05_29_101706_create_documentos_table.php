<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documenti', function (Blueprint $table) {

            $table->id();

            $table->foreignId('dipendente_id')
                 ->constrained('dipendenti')
                    ->cascadeOnDelete();

            $table->string('titolo');

            $table->string('file');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documenti');
    }
};