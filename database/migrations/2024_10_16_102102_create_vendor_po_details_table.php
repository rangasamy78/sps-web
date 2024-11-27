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
        Schema::create('vendor_po_details', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_po_id');
            $table->integer('service')->nullable();
            $table->integer('purchase_check')->nullable();
            $table->string('purchase')->nullable();
            $table->string('description')->nullable();
            $table->string('alt_qty')->nullable();
            $table->string('alt_uom')->nullable();
            $table->string('alt_ucost')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('uom')->nullable();
            $table->float('unit_cost')->nullable();
            $table->float('extended')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_po_details');
    }
};