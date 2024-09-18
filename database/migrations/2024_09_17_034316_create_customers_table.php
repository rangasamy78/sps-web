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
            $table->string('customer_code', 50);
            $table->integer('customer_type_id', 11)->nullable();
            $table->string('contact_name', 50)->nullable();

            $table->string('print_name', 150)->nullable();
            $table->string('legacy_id', 150)->nullable();
            $table->string('referred_by', 150)->nullable();

            $table->string('phone', 50)->nullable();
            $table->string('phone_2', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('acoount_email', 100)->nullable();
            $table->string('url', 50)->nullable();

            $table->text('address')->nullable();
            $table->text('address_2')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('county', 50)->nullable();
            $table->string('country_id', 50)->nullable();

            $table->text('shipping_address')->nullable();
            $table->text('shipping_address_2')->nullable();
            $table->string('shipping_city', 50)->nullable();
            $table->string('shipping_state', 50)->nullable();
            $table->string('shipping_zip', 50)->nullable();
            $table->string('shipping_county', 50)->nullable();
            $table->string('shipping_country_id', 50)->nullable();

            $table->string('parent_location', 50)->nullable();
            $table->string('multi_location',50)->nullable();
            $table->string('generic_customer',50)->nullable();
            $table->string('route_location_id', 50)->nullable();

            $table->string('is_po_required',10)->nullable();
            $table->string('apply_finance_charge',10)->nullable();
            $table->string('preferred_document_id', 50)->nullable();
            $table->string('grace_period', 50)->nullable();
            $table->string('hold_days', 50)->nullable();
            $table->date('since_date')->nullable();
            $table->string('tax_number', 50)->nullable();

            $table->string('sales_person_id', 50)->nullable();
            $table->string('secondary_sales_person_id', 50)->nullable();
            $table->string('price_level_id', 50);
            $table->tinyInteger('is_tax_exempt')->nullable();
            $table->string('tax_exempt_reason_id', 50)->nullable();
            $table->string('sales_tax_id', 50)->nullable();
            $table->string('payment_terms_id', 50);
            $table->string('exempt_certificate_no', 50)->nullable();
            $table->date('exempt_expiry_date')->nullable();

            $table->unsignedBigInteger('how_did_you_id', 50)->nullable();
            $table->unsignedBigInteger('project_type_id', 50)->nullable();
            $table->unsignedBigInteger('end_use_segment_id', 50)->nullable();
            $table->unsignedBigInteger('default_fulfillment_method_id', 50)->nullable();

            $table->string('mt_language', 50)->nullable();
            $table->decimal('credit_limit', 10, 2)->nullable();
            $table->string('past_due_alert',150)->nullable();
            $table->string('lock_alert',150)->nullable();
            $table->string('is_allow_login',10)->nullable();
            $table->string('username', 50)->nullable();
            $table->string('password', 50)->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->text('internal_notes')->nullable();
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
