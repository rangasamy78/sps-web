<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_payment_terms', function (Blueprint $table) {
            $table->id();
            $table->enum('payment_standard_date_driven', ['1', '2']);
            $table->string('payment_code')->nullable();
            $table->string('payment_label');
            $table->unsignedInteger('payment_type');
            $table->string('payment_net_due_day');
            $table->unsignedTinyInteger('payment_not_used_sales')->nullable();
            $table->unsignedTinyInteger('payment_not_used_purchases')->nullable();
            $table->string('payment_discount_percent')->nullable();
            $table->string('payment_threshold_days')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_payment_terms');
    }
};
