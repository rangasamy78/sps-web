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
        Schema::create('supplier_invoice_packing_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('po_id', 255)->nullable();
            $table->string('seq_no', 255)->nullable();
            $table->string('bar_code_no', 255)->nullable();
            $table->string('packing_list_sizes', 255)->nullable();
            $table->string('received_sizes', 255)->nullable();
            $table->string('unit_type_name', 255)->nullable();
            $table->decimal('unit_pack_length', 8, 2)->nullable();
            $table->decimal('unit_pack_width', 8, 2)->nullable();
            $table->decimal('pack_length', 8, 2)->nullable();
            $table->decimal('pack_width', 8, 2)->nullable();
            $table->decimal('rec_length', 8, 2)->nullable();
            $table->decimal('rec_width', 8, 2)->nullable();
            $table->string('transaction_no', 255)->nullable();
            $table->string('serial_no', 255)->nullable();
            $table->string('lot_block', 255)->nullable();
            $table->string('bundle', 255)->nullable();
            $table->string('supplier_ref', 255)->nullable();
            $table->unsignedBigInteger('bin_type_id')->nullable();
            $table->string('bin_type_name', 255)->nullable();
            $table->string('present_location', 255)->nullable();
            $table->text('notes')->nullable();
            $table->integer('count')->default(0);
            $table->boolean('isSeqBlock')->default(false);
            $table->boolean('isSeqBundle')->default(false);
            $table->boolean('isSeqSupplier')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoice_packing_items');
    }
};
