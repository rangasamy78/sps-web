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
        Schema::create('pre_purchase_request_files', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->unsignedBigInteger('pre_purchase_request_id');
            $table->unsignedBigInteger('user_id');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_purchase_request_files');
    }
};
