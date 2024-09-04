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
        Schema::create('inventory_adjustment_reason_codes', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->unsignedBigInteger('adjustment_type_id');
            $table->unsignedBigInteger('income_expense_account_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustment_reason_codes');
    }
};
