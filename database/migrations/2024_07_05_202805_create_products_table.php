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
            $table->bigInteger('product_id')->default(0);
            $table->string('name');
            $table->string('category');
            $table->decimal('cost_rate', 8, 2)->default(0.00);
            $table->decimal('product_rate', 8, 2)->default(0.00);
            $table->string('min');
            $table->string('max');
            $table->string('product_type');
            $table->text('description')->nullable();
            $table->integer('dripfeed')->default(0);
            $table->integer('refill')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
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
