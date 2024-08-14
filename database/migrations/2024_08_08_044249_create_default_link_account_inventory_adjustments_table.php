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
        Schema::create('default_link_account_inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('positive_adjustment_id')->nullable();
            $table->unsignedBigInteger('inventory_write_off_id')->nullable();
            $table->unsignedBigInteger('reclassify_renumbering_split_id')->nullable();
            $table->unsignedBigInteger('revaluation_adjustment_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_link_account_inventory_adjustments');
    }
};
