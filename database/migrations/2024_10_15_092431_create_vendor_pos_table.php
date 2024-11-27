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
        Schema::create('vendor_pos', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->nullable();
            $table->integer('vendor_id');
            $table->integer('location_id')->nullable();
            $table->date('transaction_date');
            $table->date('eta_date')->nullable();
            $table->integer('payment_term_id');
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->text('printed_notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->integer('vendor_po_terms_id')->nullable();
            $table->float('extended_total')->nullable();
            $table->enum('status', ['Pending', 'Fullfilled', 'Closed'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_pos');
    }
};