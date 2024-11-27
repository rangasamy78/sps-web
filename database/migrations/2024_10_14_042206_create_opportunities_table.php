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
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('opportunity_code');
            $table->date('opportunity_date');
            $table->bigInteger('location_id')->unsigned();
            $table->bigInteger('end_use_segment_id')->unsigned()->nullable();
            $table->bigInteger('project_type_id')->unsigned()->nullable();
            $table->bigInteger('opportunity_stage_id')->unsigned()->nullable();
            $table->tinyInteger('contact_mode')->comment('1: Walkin , 2: Phone,3:Fax,4:Email')->nullable();
            $table->bigInteger('billing_customer_id')->unsigned();
            $table->string('attn', 50)->nullable();
            $table->bigInteger('price_level_label_id')->unsigned();
            $table->bigInteger('primary_sales_person_id')->unsigned();
            $table->bigInteger('secondary_sales_person_id')->unsigned()->nullable();
            $table->string('total_value')->nullable();
            $table->bigInteger('sales_tax_id')->unsigned()->nullable();
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
            $table->bigInteger('how_did_hear_about_us_id')->unsigned()->nullable();
            $table->boolean('is_do_not_send_email')->default(false);
            $table->bigInteger('fabricator_id')->unsigned()->nullable();
            $table->bigInteger('designer_id')->unsigned()->nullable();
            $table->bigInteger('builder_id')->unsigned()->nullable();
            $table->text('special_instructions')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('printed_notes')->nullable();
            $table->text('survey_rating_notes')->nullable();
            $table->bigInteger('probability_to_close_id')->unsigned()->nullable();
            $table->bigInteger('login_user_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
