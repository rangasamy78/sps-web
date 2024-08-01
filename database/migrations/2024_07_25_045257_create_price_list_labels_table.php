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
        Schema::create('price_list_labels', function (Blueprint $table) {
            $table->id();
            $table->string('price_level');
            $table->string('price_code');
            $table->string('price_label');
            $table->string('price_notes');
            $table->unsignedInteger('default_discount')->nullable();
            $table->unsignedInteger('default_margin')->nullable();
            $table->unsignedInteger('default_markup')->nullable();
            $table->unsignedInteger('sales_person_commission')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_list_labels');
    }
};
