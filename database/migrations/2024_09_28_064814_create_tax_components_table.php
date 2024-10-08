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
        Schema::create('tax_components', function (Blueprint $table) {
            $table->id();
            $table->string('sort_order')->nullable();
            $table->string('component_name');
            $table->string('component_tax_id')->nullable();
            $table->integer('authority_id')->nullable();
            $table->integer('sales_tax_id');
            $table->integer('tax_code_id')->nullable();
            $table->decimal('new_tax_component_rate', 8, 2)->nullable();
            $table->decimal('tax_code_total', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_components');
    }
};
