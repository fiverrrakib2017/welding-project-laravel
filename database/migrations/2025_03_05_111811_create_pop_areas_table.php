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
        Schema::create('pop_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pop_id');
            $table->string('name');
            $table->string('billing_cycle')->nullable();
            $table->timestamps();

            $table->foreign('pop_id')->references('id')->on('pop_branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pop_areas');
    }
};
