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
        Schema::create('cable_histories', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->bigInteger('user_id');
            $table->bigInteger('cable_id');
            $table->integer('plan_id');
            $table->string('plan_amount');
            $table->string('smart_card_number');
            $table->integer('balance_before');
            $table->integer('balance_after');
            $table->string('customer_name');
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
        Schema::dropIfExists('cable_histories');
    }
};
