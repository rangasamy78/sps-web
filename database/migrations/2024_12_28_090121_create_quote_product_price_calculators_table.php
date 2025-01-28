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
        Schema::create('quote_product_price_calculators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_product_id');
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('supplier_unit_cost', 15, 2)->nullable();
            $table->decimal('subtotal_area', 15, 2)->nullable();
            $table->decimal('subtotal_extended', 15, 2)->nullable();
            $table->decimal('markup_multiplier', 5, 2)->nullable();
            $table->decimal('total_markup_multiplier', 5, 2)->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->decimal('tax_amount', 15, 2)->nullable();
            $table->decimal('total_tax_amount', 15, 2)->nullable();
            $table->decimal('additional_charges', 15, 2)->nullable();
            $table->decimal('delivery_charges', 15, 2)->nullable();
            $table->decimal('total_cost', 15, 2)->nullable();
            $table->decimal('product_charges', 15, 2)->nullable();
            $table->decimal('product_charges_amount', 15, 2)->nullable();
            $table->decimal('product_charges_total', 15, 2)->nullable();
            $table->decimal('fab_other', 15, 2)->nullable();
            $table->decimal('fab_other_amount', 15, 2)->nullable();
            $table->decimal('fab_other_total', 15, 2)->nullable();
            $table->decimal('total_quote_slab', 15, 2)->nullable();
            $table->decimal('total_quote_price', 15, 2)->nullable();
            $table->decimal('quote_total', 15, 2)->nullable();
            $table->decimal('wastage_amount', 15, 2)->nullable();
            $table->decimal('wastage_percentage', 5, 2)->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_product_price_calculators');
    }
};
