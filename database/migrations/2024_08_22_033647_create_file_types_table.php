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
        Schema::create('file_types', function (Blueprint $table) {
            $table->id();
            $table->string('view_in');
            $table->string('file_type');
            $table->unsignedInteger('file_type_opportunity')->nullable();
            $table->unsignedInteger('file_type_quote')->nullable();
            $table->unsignedInteger('file_type_saleorder')->nullable();
            $table->unsignedInteger('file_type_invoice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_types');
    }
};
