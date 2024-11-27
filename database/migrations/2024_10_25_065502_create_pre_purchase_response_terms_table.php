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
        Schema::create('pre_purchase_response_terms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->unsigned();
            $table->unsignedBigInteger('pre_purchase_request_id');
            $table->bigInteger('ship_to_location_id')->unsigned()->nullable();
            $table->string('requested_by_name')->nullable();
            $table->string('requested_payment_terms')->nullable();
            $table->string('requested_shipment_terms')->nullable();
            $table->date('required_ship_date')->nullable();
            $table->bigInteger('payment_term_id')->unsigned()->nullable();
            $table->string('response_by_name')->nullable();
            $table->string('response_payment_terms')->nullable();
            $table->unsignedBigInteger('response_shipment_term_id');
            $table->string('response_shipment_terms')->nullable();
            $table->date('response_ship_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_purchase_response_terms');
    }
};
