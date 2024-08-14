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
        Schema::create('default_link_account_other_charges_discounts_variances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('other_charges_in_po_sipl_id')->nullable();
            $table->unsignedBigInteger('payments_discount_id')->nullable();
            $table->unsignedBigInteger('restocking_fees_on_pur_return_id')->nullable();
            $table->unsignedBigInteger('freight_account_on_purchase_id')->nullable();
            $table->unsignedBigInteger('supplier_invoice_variance_id')->nullable();
            $table->unsignedBigInteger('supp_credit_memos_variance_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_link_account_other_charges_discounts_variances');
    }
};
