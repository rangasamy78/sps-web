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
        Schema::create('transaction_startings', function (Blueprint $table) {
            $table->id();
            $table->integer('po_starting_number')->nullable();
            $table->integer('supplier_invoice_starting_number')->nullable();
            $table->integer('pre_sale_starting_number')->nullable();
            $table->integer('sale_order_starting_number')->nullable();
            $table->integer('delivery_starting_number')->nullable();
            $table->integer('invoice_starting_number')->nullable();
            $table->integer('finance_charge_invoice_starting_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_startings');
    }
};
