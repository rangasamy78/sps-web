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
        Schema::create('product_price', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->float('homeowner_price')->nullable();
            $table->float('bundle_price')->nullable();
            $table->float('special_price')->nullable();
            $table->float('loose_slab_price')->nullable();
            $table->float('bundle_price_sqft')->nullable();
            $table->float('special_price_per_sqft')->nullable();
            $table->float('owner_approval_price')->nullable();
            $table->float('loose_slab_per_slab')->nullable();
            $table->float('bundle_price_per_slab')->nullable();
            $table->float('special_price_per_slab')->nullable();
            $table->float('owner_approval_price_per_slab')->nullable();
            $table->float('price12')->nullable();
            $table->string('price_range')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price');
    }
};
