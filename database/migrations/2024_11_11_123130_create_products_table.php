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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 55);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->integer('purchase_ac');
            $table->integer('sales_ac');
            $table->unsignedBigInteger('unit_id');
            $table->double('purchase_price');
            $table->double('sale_price');
            $table->unsignedBigInteger('store_id');
            $table->text('note')->nullable();
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('category_id')->on('product__categories')->references('id')->onDelete('cascade');

            $table->foreign('brand_id')->on('product__brands')->references('id')->onDelete('cascade');
            $table->foreign('unit_id')->on('units')->references('id')->onDelete('cascade');
            $table->foreign('store_id')->on('stores')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
