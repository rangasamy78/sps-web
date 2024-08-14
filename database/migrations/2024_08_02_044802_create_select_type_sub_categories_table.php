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
        Schema::create('select_type_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('select_type_category_id');
            $table->text('select_type_sub_category_name')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('select_type_sub_categories');
    }
};
