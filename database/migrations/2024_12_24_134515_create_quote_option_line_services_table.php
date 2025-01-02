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
        Schema::create('quote_option_line_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_service_id');
            $table->unsignedBigInteger('service_id');
            $table->text('description')->nullable();
            $table->boolean('is_sold_as')->default(false);
            $table->integer('quantity')->nullable();
            $table->decimal('unit_price', 8, 2)->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_option_line_services');
    }
};
