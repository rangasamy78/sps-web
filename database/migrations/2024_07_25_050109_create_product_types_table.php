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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('product_type');
            $table->integer('indivisible')->default(0);
            $table->integer('non_serialized')->default(0);
            $table->string('inventory_gl_account')->nullable();
            $table->string('sales_gl_account')->nullable();
            $table->string('cogs_gl_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
};