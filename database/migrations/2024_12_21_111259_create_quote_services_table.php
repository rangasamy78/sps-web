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
        Schema::create('quote_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->unsignedBigInteger( 'service_id');
            $table->text('description')->nullable();
            $table->boolean('is_sold_as')->default(false);
            $table->integer('service_quantity');
            $table->decimal('service_unit_price', 8, 2);
            $table->decimal('service_amount', 8, 2);
            $table->boolean('is_tax')->default(false);
            $table->boolean('is_hide_line')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_services');
    }
};
