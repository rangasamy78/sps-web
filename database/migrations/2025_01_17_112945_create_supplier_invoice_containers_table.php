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
        Schema::create('supplier_invoice_containers', function (Blueprint $table) {
            $table->id();
            $table->string('container_number');
            $table->date('received_on')->nullable();
            $table->string('received_by');
            $table->text('notes')->nullable();
            $table->integer('po_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoice_containers');
    }
};
