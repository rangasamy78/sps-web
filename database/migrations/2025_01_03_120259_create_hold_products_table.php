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
        Schema::create('hold_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hold_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('product_quantity')->nullable();
            $table->decimal('product_unit_price', 8, 2)->nullable();
            $table->decimal('product_amount', 8, 2)->nullable();
            $table->boolean('is_sold_as')->default(false);
            $table->boolean('is_tax')->default(true);
            $table->text('product_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hold_products');
    }
};
