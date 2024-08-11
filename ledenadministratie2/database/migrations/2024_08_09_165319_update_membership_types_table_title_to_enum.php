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
        Schema::table('membership_types', function (Blueprint $table) {
            // Wijzig de 'title' kolom naar een ENUM met de gewenste waarden
            $table->enum('title', ['jeugd', 'aspirant', 'junior', 'senior', 'oudere'])
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_types', function (Blueprint $table) {
            // Terugdraaien van de ENUM naar de oorspronkelijke string
            $table->string('title', 255)->change();
        });
    }
};
