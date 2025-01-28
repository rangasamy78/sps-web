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
        Schema::create('holds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opportunity_id')->nullable();
            $table->string('hold_code');
            $table->date('hold_date');
            $table->time('hold_time')->nullable();
            $table->date('expiry_date');
            $table->string('customer_po', 50)->nullable();
            $table->unsignedBigInteger('project_type_id')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->enum('pick_ticket_restriction', ['Exact Slab', 'Within Lot', 'Within Product'])->default('Exact Slab');
            $table->unsignedBigInteger('billing_customer_id');
            $table->string('bill_to_attn', 50)->nullable();
            $table->string('bill_to_fax', 50)->nullable();
            $table->string('bill_to_mobile', 50)->nullable();
            $table->unsignedBigInteger('payment_term_id')->nullable();
            $table->unsignedBigInteger('price_level_label_id')->nullable();
            $table->unsignedBigInteger('primary_sales_person_id');
            $table->unsignedBigInteger('secondary_sales_person_id')->nullable();
            $table->unsignedBigInteger('sales_tax_id');
            $table->string('hold_label')->nullable();
            $table->string('job_name', 250)->nullable();
            $table->string('attn', 50)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('suite', 150)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip', 50)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->enum('delivery_type', ['Pick Up', 'Delivery']);
            $table->unsignedBigInteger('how_did_hear_about_us_id');
            $table->unsignedBigInteger('fabricator_id')->nullable();
            $table->unsignedBigInteger('designer_id')->nullable();
            $table->unsignedBigInteger('general_contractor_id')->nullable();
            $table->unsignedBigInteger('builder_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('referred_by_id')->nullable();
            $table->text('instructions')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('printed_notes')->nullable();
            $table->unsignedBigInteger('probability_to_close_id')->nullable();
            $table->text('survey_rating')->nullable();
            $table->date('release_date')->nullable();
            $table->enum('release_hold_reason', ['No response from customer', 'Customer wanted to release', 'Hold expired', 'Home Owner Bought from other company', 'Price was expensive'])->nullable();
            $table->boolean('is_released')->default(false);
            $table->decimal('total', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holds');
    }
};
