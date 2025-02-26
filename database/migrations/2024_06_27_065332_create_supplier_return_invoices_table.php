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
        Schema::create('supplier_return_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('invoice_id');
            $table->decimal('total_return_amount', 20, 2);
            $table->text('return_note')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->on('suppliers')->references('id')->onDelete('cascade');
            $table->foreign('invoice_id')->on('supplier__invoices')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_return_invoices');
    }
};
