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
        Schema::create('default_link_account_banking_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receipt_cash_account_id')->nullable();
            $table->unsignedBigInteger('miscellaneous_income_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_link_account_banking_receipts');
    }
};
