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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('phone_2')->nullable();
            $table->string('subject');
            $table->date('hire_date');
            $table->string('address');
            $table->string('photo')->nullable();
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('national_id')->unique();
            $table->string('religion');
            $table->string('blood_group')->nullable();
            $table->string('highest_education');
            $table->string('previous_school')->nullable();
            $table->string('designation');
            $table->integer('salary');
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->text('remarks')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
