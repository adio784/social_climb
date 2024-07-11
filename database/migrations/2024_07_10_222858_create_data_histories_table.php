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
        Schema::create('data_histories', function (Blueprint $table) {
            $table->id();
            $table->string('network_id');
            $table->foreign('plan_id')->constrained('data')->onDelete('cascade');
            $table->foreign('user_id')->constrained('users')->onDelete('cascade');
            $table->string('data_type', 30)->nullable();
            $table->string('mobile_number', 30);
            $table->string('Status', 30);
            $table->string('medium', 30);
            $table->string('balance_before', 30);
            $table->string('balance_after', 30)->nullable();
            $table->string('plan_amount', 30);
            $table->boolean('Ported_number')->nullable();
            $table->string('ident', 30);
            $table->boolean('refund')->nullable();
            $table->longText('api_response');
            $table->foreign('network_id')->references('id')->on('vtuapp_network');
            $table->foreign('plan_id')->references('id')->on('vtuapp_plan');
            $table->foreign('user_id')->references('id')->on('vtuapp_customuser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_histories');
    }
};
