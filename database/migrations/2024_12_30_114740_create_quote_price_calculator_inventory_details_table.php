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
        Schema::create('quote_price_calculator_inventory_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_product_price_calculator_id');
            $table->string('serial_number')->nullable();
            $table->string('lot_name')->nullable();
            $table->string('bundle')->nullable();
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->integer('slabs')->nullable();
            $table->decimal('area', 15, 2)->nullable();
            $table->decimal('unit_cost', 15, 2)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_price_calculator_inventory_details');
    }
};
