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
        Schema::create('sub_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ledger_id');
            $table->string('sub_ledger_name');
            $table->integer('status');
            $table->timestamps();
            
            $table->foreign('ledger_id')
            ->on('ledgers')
            ->references('id')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_ledgers');
    }
};
