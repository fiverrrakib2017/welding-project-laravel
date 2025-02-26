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
        Schema::create('student_bill_collection_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_collection_id');
            $table->unsignedBigInteger('fees_type_id');
            $table->decimal('amount', 10, 2);
            $table->integer('status');
            $table->text('month')->nullable();
            $table->integer('year');
            $table->timestamps();

            $table->foreign('bill_collection_id')->references('id')->on('student_bill_collections')->onDelete('cascade');

            $table->foreign('fees_type_id')->references('id')->on('student_fees_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_bill_collection_items');
    }
};
