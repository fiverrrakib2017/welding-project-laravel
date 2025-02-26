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
        Schema::create('supplier_return_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('return_invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('return_qty');
            $table->decimal('return_price', 10, 2);
            $table->decimal('total_return_price', 10, 2);
            $table->timestamps();

            $table->foreign('return_invoice_id')->references('id')->on('supplier_return_invoices')->onDelete('cascade');
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_return_invoice_details');
    }
};
