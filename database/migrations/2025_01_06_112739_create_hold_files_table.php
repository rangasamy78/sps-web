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
        Schema::create('hold_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->integer('file_type_id')->nullable();
            $table->string('notes')->nullable();
            $table->integer('hold_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hold_files');
    }
};
