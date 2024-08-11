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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);  // VARCHAR(255)
            $table->date('birth_date');
            $table->string('family_role', 255); // VARCHAR(255)
            $table->unsignedBigInteger('family_id');      // Foreign key
            $table->unsignedBigInteger('member_role_id');  // Foreign key
          	$table->unsignedBigInteger('membership_type_id');  // Foreign key
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->foreign('member_role_id')->references('id')->on('member_roles')->onDelete('cascade');
            $table->foreign('membership_type_id')->references('id')->on('membership_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
