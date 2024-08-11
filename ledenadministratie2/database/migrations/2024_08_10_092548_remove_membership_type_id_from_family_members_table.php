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
        Schema::table('family_members', function (Blueprint $table) {
            // Eerst de foreign key constraint verwijderen
            $table->dropForeign(['membership_type_id']);

            // Daarna de kolom verwijderen
            $table->dropColumn('membership_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('family_members', function (Blueprint $table) {
            // Voeg de kolom weer toe
            $table->unsignedBigInteger('membership_type_id')->nullable();

            // Voeg de foreign key constraint weer toe
            $table->foreign('membership_type_id')->references('id')->on('membership_types');
        });
    }
};
