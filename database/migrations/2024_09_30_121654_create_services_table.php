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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->string('service_sku')->nullable();
            $table->integer('unit_of_measure_id');
            $table->integer('service_category_id')->nullable();
            $table->integer('service_type_id')->nullable();
            $table->integer('service_group_id')->nullable();
            $table->integer('expenditure_id')->nullable();
            $table->string('avg_est_cost')->nullable();
            $table->integer('gl_sales_account_id');
            $table->integer('gl_cost_of_sales_account_id');
            $table->integer('is_taxable_item')->nullable();
            $table->integer('frequent_in_so')->nullable();
            $table->integer('frequent_in_customer_cm')->nullable();
            $table->integer('frequent_in_po')->nullable();
            $table->integer('frequent_in_supplier_cm')->nullable();
            $table->text('notes')->nullable();
            $table->text('internal_instruction')->nullable();
            $table->text('disclaimer')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
