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
        Schema::create('quote_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->unsignedBigInteger( 'product_id');
            $table->text('description')->nullable();
            $table->boolean('is_sold_as')->default(false);
            $table->integer('product_quantity');
            $table->decimal('product_unit_price', 8, 2);
            $table->decimal('product_amount', 8, 2);
            $table->boolean('is_tax')->default(false);
            $table->boolean('is_hide_line')->default(false);
            $table->text('notes')->nullable();
            $table->enum('inventory_restriction', ['exact_slab', 'within_lot', 'within_product'])->default('exact_slab');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_products');
    }
};
