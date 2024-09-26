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
        Schema::create('expenditures', function (Blueprint $table) {
            $table->id();
            $table->string('expenditure_name', 150);
            $table->string('print_name', 150);
            $table->string('expenditure_code', 50)->nullable();
            $table->integer('expenditure_type_id')->nullable();
            $table->integer('parent_location_id');
            $table->string('contact_name', 150)->nullable();
            $table->date('since_date')->nullable();
            $table->string('primary_phone', 50)->nullable();
            $table->string('secondary_phone', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('website', 50)->nullable();
            $table->text('address')->nullable();
            $table->text('suite')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip', 50)->nullable();
            $table->integer('country_id')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_suite')->nullable();
            $table->string('shipping_city', 50)->nullable();
            $table->string('shipping_state', 50)->nullable();
            $table->string('shipping_zip', 50)->nullable();
            $table->integer('shipping_country_id')->nullable();
            $table->integer('payment_terms')->nullable();
            $table->string('currency', 50)->nullable();
            $table->integer('expense_account_id')->nullable();
            $table->integer('payment_method_id')->nullable();
            $table->string('account', 50)->nullable();
            $table->string('tax', 50)->nullable();
            $table->string('memo', 100)->nullable();
            $table->string('ein', 100)->nullable();
            $table->tinyInteger('is_generic_expenditure')->nullable();
            $table->tinyInteger('is_print_1099')->nullable();
            $table->tinyInteger('is_frieght_expenditure')->nullable();
            $table->tinyInteger('is_sub_contractor')->nullable();
            $table->tinyInteger('is_allow_login')->nullable();
            $table->string('expenditure_username', 50)->nullable();
            $table->string('expenditure_password', 50)->nullable();
            $table->text('internal_notes')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenditures');
    }
};
