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
        Schema::create('pre_purchase_request_products', function (Blueprint $table) {
            $table->id();
            $table->string('s_no')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('pre_purchase_request_id');
            $table->string('product_sku')->nullable();
            $table->string('generic_name')->nullable();
            $table->string('generic_sku')->nullable();
            $table->string('avg_est_cost')->nullable();
            $table->text('description')->nullable();
            $table->string('purchasing_note')->nullable();
            $table->string('pur_qty')->nullable();
            $table->string('pur_uom_id')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('picking_qty')->nullable();
            $table->string('picking_unit')->nullable();
            $table->string('slab')->nullable();
            $table->decimal('qty', 8, 2);
            $table->decimal('response_qty', 8, 2)->nullable();
            $table->string('unit_price')->nullable();
            $table->decimal('total_price', 8, 2)->nullable();
            $table->text('comments')->nullable();
            $table->text('requested_product')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_purchase_request_products');
    }
};
