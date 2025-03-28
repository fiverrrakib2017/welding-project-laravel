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
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('house_allowance', 10, 2);
            $table->decimal('medical_allowance ', 10, 2);
            $table->decimal('other_allowance  ', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('net_salary ', 10, 2);
            $table->date('effective_from')->nullable();
            $table->boolean('is_current ')->default(true);
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salaries');
    }
};
