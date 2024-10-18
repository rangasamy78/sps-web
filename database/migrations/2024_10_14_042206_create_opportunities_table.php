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
            $table->string('opportunity');
            $table->date('opportunity_date');
            $table->bigInteger('end_use_segment_id')->unsigned()->nullable();
            $table->bigInteger('project_type_id')->unsigned()->nullable();
            $table->bigInteger('stage_id')->unsigned()->nullable();
            $table->tinyInteger('contact_mode')->comment('1: Walkin , 2: Phone,3:Fax,4:Email')->nullable();
            $table->bigInteger('billing_customer_id')->unsigned();
            $table->string('attn', 50)->nullable();
            $table->bigInteger('price_level_label_id')->unsigned();
            $table->bigInteger('primary_sales_person_id')->unsigned();
            $table->bigInteger('secondary_sales_person_id')->unsigned()->nullable();
            $table->string('total_value')->nullable();
            $table->bigInteger('sales_tax_id')->unsigned()->nullable();
            $table->string('delivery_end_customer', 250)->nullable();
            $table->string('delivery_attn', 50)->nullable();
            $table->string('delivery_ship_to', 250)->nullable();
            $table->string('delivery_ship_to_name', 100)->nullable();
            $table->string('delivery_address', 250)->nullable();
            $table->string('delivery_suite', 150)->nullable();
            $table->string('delivery_city', 50)->nullable();
            $table->string('delivery_state', 50)->nullable();
            $table->string('delivery_zip', 50);
            $table->bigInteger('delivery_county_id')->unsigned()->nullable();
            $table->bigInteger('delivery_country_id')->unsigned()->nullable();
            $table->string('delivery_phone', 50)->nullable();
            $table->string('delivery_fax', 50)->nullable();
            $table->string('delivery_mobile', 50)->nullable();
            $table->string('delivery_lot', 50)->nullable();
            $table->string('delivery_sub_division', 50)->nullable();
            $table->string('delivery_email', 50)->nullable();
            $table->bigInteger('delivery_how_did_hear_about_us_id')->unsigned();
            $table->boolean('delivery_is_do_not_send_email')->default(false);
            $table->string('pick_end_customer', 250)->nullable();
            $table->string('pick_attn', 50)->nullable();
            $table->string('pick_phone', 50)->nullable();
            $table->string('pick_fax', 50)->nullable();
            $table->string('pick_mobile', 50)->nullable();
            $table->string('pick_lot', 50)->nullable();
            $table->string('pick_sub_division', 50)->nullable();
            $table->string('pick_email', 50)->nullable();
            $table->bigInteger('pick_how_did_hear_about_us_id')->unsigned();
            $table->boolean('pick_is_do_not_send_email')->default(false);
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
