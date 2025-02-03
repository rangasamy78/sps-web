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
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->string('sales_order_code');
            $table->date('sales_order_date');
            $table->bigInteger('location_id')->unsigned();
            $table->string('customer_po_code')->nullable();
            $table->bigInteger('billing_customer_id')->unsigned();
            $table->string('attn', 50)->nullable();
            $table->bigInteger('payment_term_id')->unsigned();
            $table->bigInteger('price_level_label_id')->unsigned();
            $table->bigInteger('primary_sales_person_id')->unsigned();
            $table->bigInteger('secondary_sales_person_id')->unsigned()->nullable();
            $table->boolean('is_cod')->default(false);
            $table->enum('ship_to_type', ['Pick Up', 'Delivery'])->default('Delivery');
            $table->string('ship_to_job_name', 250)->nullable();
            $table->string('ship_to_attn', 50)->nullable();
            $table->string('ship_to_id', 250)->nullable();
            $table->string('ship_to_name', 100)->nullable();
            $table->string('ship_to_address', 250)->nullable();
            $table->string('ship_to_suite', 150)->nullable();
            $table->string('ship_to_city', 50)->nullable();
            $table->string('ship_to_state', 50)->nullable();
            $table->string('ship_to_zip', 50)->nullable();
            $table->bigInteger('ship_to_county_id')->unsigned()->nullable();
            $table->bigInteger('ship_to_country_id')->unsigned()->nullable();
            $table->string('ship_to_phone', 50)->nullable();
            $table->string('ship_to_fax', 50)->nullable();
            $table->string('ship_to_mobile', 50)->nullable();
            $table->string('ship_to_lot', 50)->nullable();
            $table->string('ship_to_sub_division', 50)->nullable();
            $table->string('ship_to_email', 50)->nullable();
            $table->bigInteger('sales_tax_id')->unsigned()->nullable();
            $table->date('requested_ship_date')->nullable();
            $table->date('est_delivery_date')->nullable();
            $table->bigInteger('fabricator_id')->unsigned()->nullable();
            $table->bigInteger('designer_id')->unsigned()->nullable();
            $table->bigInteger('builder_id')->unsigned()->nullable();
            $table->decimal('commission_amount', 8, 2)->nullable();
            $table->text('commission_notes')->nullable();
            $table->text('special_instructions')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('printed_notes')->nullable();
            $table->text('survey_rating_notes')->nullable();
            $table->bigInteger('freight_carrier_id')->unsigned()->nullable();
            $table->bigInteger('route_id')->unsigned()->nullable();
            $table->string('shipping_tracking_number')->nullable();
            $table->bigInteger('print_doc_disclaimer_id')->unsigned()->nullable();
            $table->text('print_doc_description_editor')->nullable();
            $table->bigInteger('entered_by_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_orders');
    }
};
