<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendor_po_prepayments', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_po_id');
            $table->integer('cash_account_id');
            $table->date('payment_date');
            $table->date('date_on_check');
            $table->string('check');
            $table->integer('payment_method_id');
            $table->string('memo')->nullable();
            $table->integer('account_id')->nullable();
            $table->string('description')->nullable();
            $table->float('amount')->nullable();
            $table->text('internal_notes')->nullable();
            $table->float('vendor_po_total')->nullable();
            $table->float('misc_amount')->nullable();
            $table->float('net_amount_due')->nullable();
            $table->string('po_percentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_po_prepayments');
    }
};