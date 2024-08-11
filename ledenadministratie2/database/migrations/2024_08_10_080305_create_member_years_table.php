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
        Schema::create('member_years', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_member_id');
            $table->unsignedBigInteger('fiscal_year_id');
            $table->timestamps();

            // Voeg de foreign key constraint toe voor family_member_id
            $table->foreign('family_member_id')->references('id')->on('family_members')->onDelete('cascade');

            // Voeg de foreign key constraint toe voor fiscal_year_id
            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_years');
    }
};
