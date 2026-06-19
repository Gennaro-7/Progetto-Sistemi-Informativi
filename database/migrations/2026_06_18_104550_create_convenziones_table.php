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
    Schema::create('convenzioni', function (Blueprint $table) {
        $table->id();

        $table->string('titolo');
        $table->text('descrizione');

        $table->string('azienda')->nullable();

        $table->integer('sconto')->nullable();

        $table->string('link')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convenziones');
    }
};
