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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->text('nid_or_passport')->unique();
            $table->string('father_name');
            $table->text('permanent_address');
            $table->text('present_address');
            $table->string('mobile_number')->unique();
            $table->text('reg_no')->nullable();

            $table->text('course');
            $table->string('course_duration');
            $table->string('course_end');
            $table->integer('is_delete')->default('0');
            $table->integer('is_completed')->default('0')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            //$table->foreign('user_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
