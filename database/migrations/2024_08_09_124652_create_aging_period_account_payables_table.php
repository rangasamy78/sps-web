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
            $table->TinyInteger('invoice_aging_period_ap_1_start');
            $table->TinyInteger('invoice_aging_period_ap_1_end');
            $table->TinyInteger('invoice_aging_period_ap_2_start');
            $table->TinyInteger('invoice_aging_period_ap_2_end');
            $table->TinyInteger('invoice_aging_period_ap_3_start');
            $table->TinyInteger('invoice_aging_period_ap_3_end');
            $table->TinyInteger('invoice_aging_period_ap_4_start');
            $table->TinyInteger('invoice_aging_period_ap_4_end');
            $table->TinyInteger('due_date_aging_period_ap_1_start');
            $table->TinyInteger('due_date_aging_period_ap_1_end');
            $table->TinyInteger('due_date_aging_period_ap_2_start');
            $table->TinyInteger('due_date_aging_period_ap_2_end');
            $table->TinyInteger('due_date_aging_period_ap_3_start');
            $table->TinyInteger('due_date_aging_period_ap_3_end');
            $table->TinyInteger('due_date_aging_period_ap_4_start');
            $table->TinyInteger('due_date_aging_period_ap_4_end');
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
