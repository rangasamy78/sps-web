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
        Schema::create('vendor_po_new_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_po_id');
            $table->string('transaction_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();
            $table->integer('payments_terms_id')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('contact_location_id')->nullable();
            $table->integer('hold_payment_check')->nullable();
            $table->text('hold_payment_reason')->nullable();
            $table->float('extended_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_po_new_bills');
    }
};