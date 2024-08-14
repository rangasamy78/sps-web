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
        Schema::create('default_link_account_banking_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_payment_cash_account_id')->nullable();
            $table->unsignedBigInteger('vendor_payment_cash_account_id')->nullable();
            $table->unsignedBigInteger('customer_payment_cash_account_id')->nullable();
            $table->unsignedBigInteger('miscellaneous_expense_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_link_account_banking_payments');
    }
};
