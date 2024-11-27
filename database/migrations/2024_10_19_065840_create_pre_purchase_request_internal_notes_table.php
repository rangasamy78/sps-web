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
        Schema::create('pre_purchase_request_internal_notes', function (Blueprint $table) {
            $table->id();
            $table->text('internal_notes');
            $table->unsignedBigInteger('pre_purchase_request_id');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_purchase_request_internal_notes');
    }
};
