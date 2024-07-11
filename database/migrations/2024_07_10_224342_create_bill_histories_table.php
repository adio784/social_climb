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
        Schema::create('bill_histories', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->integer('user_id');
            $table->integer('disco_id');
            $table->string('bill_amount');
            $table->string('paid_amount');
            $table->string('balance_bfo');
            $table->string('balance_aft');
            $table->string('meter_number');
            $table->string('meter_type');
            $table->string('customer_name');
            $table->string('customer_address');
            $table->string('customer_phone');
            $table->string('token');
            $table->boolean('refund')->default(false);
            $table->string('status')->default('processing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_histories');
    }
};
