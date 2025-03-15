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
        Schema::create('sms_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('api_url');
            $table->string('api_key');
            $table->string('sender_id');
            $table->string('default_country_code', 5)->default('+880');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_configurations');
    }
};
