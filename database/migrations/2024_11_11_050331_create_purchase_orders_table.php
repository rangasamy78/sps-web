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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->nullable();
            $table->date('po_date')->nullable();
            $table->string('supplier_so_number')->nullable();
            $table->date('required_ship_date')->nullable();
            $table->date('eta_date')->nullable();
            $table->date('po_expiry_date')->nullable();
            $table->string('container_number')->nullable();
            $table->string('shipment_term_id')->nullable();
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->text('supplier_address_id')->nullable();
            $table->text('supplier_address')->nullable();
            $table->string('supplier_suite')->nullable();
            $table->string('supplier_city', 50)->nullable();
            $table->string('supplier_state', 50)->nullable();
            $table->string('supplier_zip', 10)->nullable();
            $table->bigInteger('supplier_country_id')->unsigned()->nullable();
            $table->bigInteger('payment_term_id')->unsigned()->nullable();
            $table->bigInteger('purchase_location_id')->unsigned()->nullable();
            $table->text(column: 'purchase_location_address')->nullable();
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
            $table->bigInteger('freight_forwarder_id')->unsigned()->nullable();
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
            $table->float('sub_total')->nullable();
            $table->float('extended_total')->nullable();
            $table->enum('status', ['Pending', 'Fullfilled', 'Closed'])->default('Pending');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};