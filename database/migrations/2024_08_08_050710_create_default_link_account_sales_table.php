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
        Schema::create('default_link_account_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_ar_id')->nullable();
            $table->unsignedBigInteger('sales_income_product_id')->nullable();
            $table->unsignedBigInteger('sales_income_service_id')->nullable();
            $table->unsignedBigInteger('cogs_account_id')->nullable();
            $table->unsignedBigInteger('restocking_fee_income_account_id')->nullable();
            $table->unsignedBigInteger('sales_tax_liability_account_id')->nullable();
            $table->unsignedBigInteger('sales_discount_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_link_account_sales');
    }
};
