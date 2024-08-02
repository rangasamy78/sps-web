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
        Schema::create('credit_check_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('packing_list');
            $table->tinyInteger('invoice');
            $table->tinyInteger('credit_check');
            $table->tinyInteger('purchase_order');
            $table->tinyInteger('relock_sales_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_check_settings');
    }
};
