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
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('course_end');
            $table->date('course_start_date')->nullable()->after('course_duration');
            $table->date('course_end_date')->nullable()->after('course_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['course_start_date', 'course_end_date']);
            //$table->string('course_end')->nullable()->after('course_duration');
        });
    }
};
