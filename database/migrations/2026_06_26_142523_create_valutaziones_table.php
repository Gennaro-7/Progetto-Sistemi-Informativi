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
    Schema::create('valutazioni', function (Blueprint $table) {

        $table->id();

        $table->foreignId('dipendente_id')
      ->constrained('dipendenti')
      ->onDelete('cascade');

        $table->string('categoria');

        $table->integer('voto');

        $table->text('commento');

        $table->date('data');

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valutaziones');
    }
};
