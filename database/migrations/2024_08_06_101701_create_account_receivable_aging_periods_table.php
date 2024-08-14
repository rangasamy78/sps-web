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
        Schema::create('account_receivable_aging_periods', function (Blueprint $table) {
            $table->id();
            $table->integer('ar_invoice_date_start_1')->nullable();
            $table->integer('ar_invoice_date_end_1')->nullable();
            $table->integer('ar_invoice_date_start_2')->nullable();
            $table->integer('ar_invoice_date_end_2')->nullable();
            $table->integer('ar_invoice_date_start_3')->nullable();
            $table->integer('ar_invoice_date_end_3')->nullable();
            $table->integer('ar_invoice_date_start_4')->nullable();
            $table->integer('ar_invoice_date_end_4')->nullable();
            $table->integer('ar_due_date_start_2')->nullable();
            $table->integer('ar_due_date_end_2')->nullable();
            $table->integer('ar_due_date_start_3')->nullable();
            $table->integer('ar_due_date_end_3')->nullable();
            $table->integer('ar_due_date_start_4')->nullable();
            $table->integer('ar_due_date_end_4')->nullable();
            $table->integer('ar_due_date_start_5')->nullable();
            $table->integer('ar_due_date_end_5')->nullable();
            $table->tinyInteger('do_not_show_on_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_receivable_aging_periods');
    }
};
