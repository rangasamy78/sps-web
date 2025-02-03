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
        Schema::create('hold_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hold_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->text('service_description')->nullable();
            $table->integer('service_quantity')->nullable();
            $table->decimal('service_unit_price', 8, 2)->nullable();
            $table->decimal('service_amount', 8, 2)->nullable();
            $table->boolean('is_tax')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hold_services');
    }
};
