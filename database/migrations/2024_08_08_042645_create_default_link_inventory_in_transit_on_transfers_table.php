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
        Schema::create('default_link_inventory_in_transit_on_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_in_transit_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_link_inventory_in_transit_on_transfers');
    }
};
