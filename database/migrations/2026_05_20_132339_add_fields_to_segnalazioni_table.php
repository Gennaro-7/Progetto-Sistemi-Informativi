<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('segnalazioni', function (Blueprint $table) {
            $table->string('titolo')->nullable();
            $table->text('descrizione')->nullable();
            $table->string('stato')->default('aperta');
        });
    }

    public function down(): void
    {
        Schema::table('segnalazioni', function (Blueprint $table) {
            $table->dropColumn(['titolo', 'descrizione', 'stato']);
        });
    }
};