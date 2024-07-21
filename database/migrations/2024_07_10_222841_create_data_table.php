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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('network');
            $table->string('plan_size');
            $table->string('plan_measure');
            $table->decimal('cost_price', 10, 2);
            $table->decimal('plan_price', 10, 2);
            $table->string('plan_category');
            $table->string('plan_validity');
            $table->string('ussd_string');
            $table->string('sms_message');
            $table->string('vtpass_planid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
