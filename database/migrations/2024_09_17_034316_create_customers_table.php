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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 150);
            $table->string('customer_code', 50)->nullable();
            $table->bigInteger('customer_type_id')->unsigned()->nullable();
            $table->string('contact_name', 50)->nullable();
            $table->string('print_name', 150)->nullable();
            $table->bigInteger('parent_customer_id')->unsigned()->nullable();
            $table->bigInteger('referred_by_id')->unsigned()->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('phone_2', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('accounting_email', 100)->nullable();
            $table->string('url', 50)->nullable();
            $table->text('address')->nullable();
            $table->text('address_2')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('county', 50)->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->string('customer_image')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('shipping_address_2')->nullable();
            $table->string('shipping_city', 50)->nullable();
            $table->string('shipping_state', 50)->nullable();
            $table->string('shipping_zip', 50)->nullable();
            $table->string('shipping_county', 50)->nullable();
            $table->bigInteger('shipping_country_id')->unsigned()->nullable();
            $table->bigInteger('parent_location_id')->unsigned()->nullable();
            $table->tinyInteger('multi_location')->nullable();
            $table->tinyInteger('generic_customer')->nullable();
            $table->bigInteger('route_location_id')->unsigned()->nullable();
            $table->tinyInteger('is_po_required')->nullable();
            $table->tinyInteger('apply_finance_charge')->nullable();
            $table->string('preferred_document_id', 50)->nullable();
            $table->string('grace_period', 50)->nullable();
            $table->string('hold_days', 50)->nullable();
            $table->date('since_date')->nullable();
            $table->string('tax_number', 50)->nullable();
            $table->bigInteger('sales_person_id')->unsigned()->nullable();
            $table->bigInteger('secondary_sales_person_id')->unsigned()->nullable();
            $table->bigInteger('price_list_label_id')->unsigned()->nullable();
            $table->tinyInteger('is_tax_exempt')->nullable();
            $table->bigInteger('tax_exempt_reason_id')->unsigned()->nullable();
            $table->bigInteger('sales_tax_id')->unsigned()->nullable();
            $table->bigInteger('payment_terms_id')->unsigned()->nullable();
            $table->string('exempt_certificate_no', 50)->nullable();
            $table->date('exempt_expiry_date')->nullable();
            $table->bigInteger('about_us_option_id')->unsigned()->nullable();
            $table->bigInteger('project_type_id')->unsigned()->nullable();
            $table->bigInteger('end_use_segment_id')->unsigned()->nullable();
            $table->string('default_fulfillment_method_id', 50)->nullable();
            $table->string('credit_limit', 50)->nullable();
            $table->tinyInteger('is_credit_lock')->nullable();
            $table->string('sales_alert_note', 150)->nullable();
            $table->string('sales_lock_note', 150)->nullable();
            $table->string('is_allow_login', 10)->nullable();
            $table->string('username', 50)->nullable();
            $table->string('password', 50)->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->text('collection_notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->tinyInteger('is_copy_sale_order')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: Active , 2: Inactive');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
