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
        Schema::create('aging_period_account_payables', function (Blueprint $table) {
            $table->id();
            $table->TinyInteger('ap_invoice_date_start_1')->nullable();
            $table->TinyInteger('ap_invoice_date_end_1')->nullable();
            $table->TinyInteger('ap_invoice_date_start_2')->nullable();
            $table->TinyInteger('ap_invoice_date_end_2')->nullable();
            $table->TinyInteger('ap_invoice_date_start_3')->nullable();
            $table->TinyInteger('ap_invoice_date_end_3')->nullable();
            $table->TinyInteger('ap_invoice_date_start_4')->nullable();
            $table->TinyInteger('ap_invoice_date_end_4')->nullable();
            $table->TinyInteger('ap_due_date_start_2')->nullable();
            $table->TinyInteger('ap_due_date_end_2')->nullable();
            $table->TinyInteger('ap_due_date_start_3')->nullable();
            $table->TinyInteger('ap_due_date_end_3')->nullable();
            $table->TinyInteger('ap_due_date_start_4')->nullable();
            $table->TinyInteger('ap_due_date_end_4')->nullable();
            $table->TinyInteger('ap_due_date_start_5')->nullable();
            $table->TinyInteger('ap_due_date_end_5')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aging_period_account_payables');
    }
};
