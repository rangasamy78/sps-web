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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('print_name');
            $table->string('code')->nullable();
            $table->string('contact_name')->nullable();
            $table->integer('supplier_type_id')->nullable();
            $table->integer('parent_location_id');
            $table->boolean('multi_location_supplier')->default(false);
            $table->integer('language_id')->nullable();
            $table->integer('parent_supplier_id')->nullable();
            $table->string('supplier_since')->nullable();
            $table->integer('supplier_port_id')->nullable();
            $table->string('markup_multiplier')->nullable();
            $table->string('discount')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('remit_address')->nullable();
            $table->string('remit_suite')->nullable();
            $table->string('remit_city')->nullable();
            $table->string('remit_state')->nullable();
            $table->string('remit_zip')->nullable();
            $table->integer('remit_country_id')->nullable();
            $table->string('ship_address')->nullable();
            $table->string('ship_suite')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_state')->nullable();
            $table->string('ship_zip')->nullable();
            $table->integer('ship_country_id')->nullable();
            $table->string('credit_limit')->nullable();
            $table->string('ein_number')->nullable();
            $table->string('account')->nullable();
            $table->integer('currency_id');
            $table->integer('payment_terms_id');
            $table->integer('shipment_terms_id')->nullable();
            $table->integer('purchase_tax_id')->nullable();
            $table->integer('frieght_forwarder_id')->nullable();
            $table->integer('default_payment_method_id')->nullable();
            $table->string('shipping_instruction')->nullable();
            $table->string('internal_notes')->nullable();
            $table->boolean('allow_access_to_supplier')->default(false);
            $table->string('supplier_username')->nullable();
            $table->string('supplier_password')->nullable();
            $table->boolean('form_1099_printed')->default(false);
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
