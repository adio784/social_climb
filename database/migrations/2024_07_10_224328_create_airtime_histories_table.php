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
        Schema::create('airtime_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('network_id');
            $table->string('mobile_number');
            $table->string('cost_price');
            $table->string('amount_paid');
            $table->string('airtime_type');
            $table->string('reference');
            $table->string('status')->default('processing');
            $table->string('medium');
            $table->string('balance_before');
            $table->string('balance_after');
            $table->integer('ported_number')->default(0);
            $table->boolean('refunded')->default(false);
            $table->string('api_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airtime_histories');
    }
};
