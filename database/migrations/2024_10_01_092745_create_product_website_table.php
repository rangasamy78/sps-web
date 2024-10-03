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
        Schema::create('product_website', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->enum('color_enhancing', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('countertop_vanities', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('interior_floor', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('fireplace_interior_wall', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('shower_wall', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('shower_floor', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('exterior_floor', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('exterior_wall', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('pool_fountain', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('furniture_top', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('translucent', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('cut_to_size', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('sealer', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('abrasion_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('stain_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('etching_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('heat_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('uv_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('color_range', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('movement_index', ['Low', 'Medium', 'High'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_website');
    }
};
