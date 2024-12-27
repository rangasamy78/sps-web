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
        Schema::create('sale_order_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->integer('file_type_id')->nullable();
            $table->string('notes')->nullable();
            $table->integer('sales_order_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order_files');
    }
};
