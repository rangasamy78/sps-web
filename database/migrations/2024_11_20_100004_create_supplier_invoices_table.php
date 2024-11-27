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
        Schema::create('supplier_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('po_id');
            $table->string('sipl_bill')->nullable();
            $table->date('entry_date')->nullable();
            $table->string('invoice')->nullable();
            $table->string('supplier_so')->nullable();
            $table->date('ship_date')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('po_expiry_date')->nullable();
            $table->string('payment_term_id')->nullable();
            $table->date('due_date')->nullable();
            $table->date('eta_date')->nullable();
            $table->string('container_number')->nullable();
            $table->bigInteger('delivery_method_id')->unsigned()->nullable();
            $table->bigInteger('shipment_term_id')->unsigned()->nullable();
            $table->string('payment_hold')->nullable();
            $table->string('payment_hold_reason')->nullable();
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->text('supplier_address')->nullable();
            $table->string('supplier_suite')->nullable();
            $table->string('supplier_city', 50)->nullable();
            $table->string('supplier_state', 50)->nullable();
            $table->string('supplier_zip', 10)->nullable();
            $table->bigInteger('supplier_country_id')->unsigned()->nullable();
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
            $table->bigInteger('freight_forwarder_id')->unsigned()->nullable();
            $table->text('printed_notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('vessel')->nullable();
            $table->text('air_bill')->nullable();
            $table->date('planned_ex_factory')->nullable();
            $table->date('ex_factory_date')->nullable();
            $table->bigInteger('departure_port_id')->unsigned()->nullable();
            $table->bigInteger('discharge_port_id')->unsigned()->nullable();
            $table->date('etd_port')->nullable();
            $table->bigInteger('arrival_port_id')->unsigned()->nullable();
            $table->date('eta_port')->nullable();
            $table->bigInteger('wiring_instruction_id')->unsigned()->nullable();
            $table->float('item_total')->nullable();
            $table->float('other_total')->nullable();
            $table->float('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_invoices');
    }
};