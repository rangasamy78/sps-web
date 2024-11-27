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
        Schema::create('pre_purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number', 150);
            $table->date('pre_purchase_date')->nullable();
            $table->date('required_ship_date')->nullable();
            $table->date('eta_date')->nullable();
            $table->bigInteger('shipment_term_id')->unsigned()->nullable();
            $table->bigInteger('requested_by_id')->unsigned()->nullable();
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->text('supplier_primary_address')->nullable();
            $table->text('supplier_address')->nullable();
            $table->string('supplier_suite')->nullable();
            $table->string('supplier_city', 50)->nullable();
            $table->string('supplier_state', 50)->nullable();
            $table->string('supplier_zip', 10)->nullable();
            $table->bigInteger('supplier_country_id')->unsigned()->nullable();
            $table->bigInteger('payment_term_id')->unsigned()->nullable();
            $table->bigInteger('purchase_location_id')->unsigned()->nullable();
            $table->text('purchase_location_address')->nullable();
            $table->string('purchase_location_suite')->nullable();
            $table->string('purchase_location_city', 50)->nullable();
            $table->string('purchase_location_state', 50)->nullable();
            $table->string('purchase_location_zip', 10)->nullable();
            $table->bigInteger('purchase_location_country_id')->unsigned()->nullable();
            $table->bigInteger('ship_to_location_id')->unsigned()->nullable();
            $table->text('ship_to_location_attn')->nullable();
            $table->text('ship_to_location_address')->nullable();
            $table->string('ship_to_location_suite')->nullable();
            $table->string('ship_to_location_city', 50)->nullable();
            $table->string('ship_to_location_state', 50)->nullable();
            $table->string('ship_to_location_zip', 10)->nullable();
            $table->bigInteger('ship_to_location_country_id')->unsigned()->nullable();
            $table->text('printed_notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->bigInteger('special_instruction_id')->unsigned()->nullable();
            $table->text('special_instructions')->nullable();
            $table->bigInteger('pre_purchase_term_id')->unsigned()->nullable();
            $table->text('terms')->nullable();
            $table->string('conversion_rate', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_purchase_requests');
    }
};
