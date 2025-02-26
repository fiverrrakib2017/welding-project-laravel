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
        Schema::create('customer_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->integer('ticket_for');
            $table->unsignedBigInteger('ticket_assign_id');
            $table->unsignedBigInteger('ticket_complain_id');
            $table->integer('priority_id');
            $table->text('subject');
            $table->text('description');
            $table->text('note')->nullable();
            $table->string('percentage');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('ticket_assign_id')->references('id')->on('ticket_assigns')->onDelete('cascade');
            $table->foreign('ticket_complain_id')->references('id')->on('ticket_complain_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_tickets');
    }
};
