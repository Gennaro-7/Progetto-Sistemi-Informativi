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
    Schema::create('segnalazioni', function (Blueprint $table) {
        $table->id();

        $table->foreignId('dipendente_id')
              ->constrained('dipendenti')
              ->onDelete('cascade');

        $table->string('titolo');

        $table->text('descrizione');

        $table->enum('stato', [
            'aperta',
            'in_lavorazione',
            'chiusa'
        ])->default('aperta');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segnalazioni');
    }
};
