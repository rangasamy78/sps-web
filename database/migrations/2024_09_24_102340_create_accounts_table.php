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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('account_number');
            $table->integer('account_type_id');
            $table->integer('account_sub_type_id')->nullable();
            $table->integer('special_account_type_id')->nullable();
            $table->integer('account_operating_location_id')->nullable();
            $table->string('alternate_number')->nullable();
            $table->string('alternate_name')->nullable();
            $table->integer('is_sub_account_of_id')->nullable();
            $table->integer('currency_id');
            $table->string('statement_end_day')->nullable();
            $table->boolean('is_default_account')->default(false);
            $table->boolean('is_budgeted_account')->default(false);
            $table->boolean('is_tax_account')->default(false);
            $table->boolean('is_reconciled_account')->default(false);
            $table->boolean('is_allow_bank_reconciliation')->default(false);
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('routing_number')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->boolean('is_allow_printing_checks')->default(false);
            $table->string('internal_notes')->nullable();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
