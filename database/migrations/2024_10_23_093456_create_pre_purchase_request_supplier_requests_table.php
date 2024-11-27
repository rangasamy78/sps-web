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
        Schema::create('pre_purchase_request_supplier_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->text('supplier_address')->nullable();
            $table->string('supplier_suite')->nullable();
            $table->string('supplier_city', 50)->nullable();
            $table->string('supplier_state', 50)->nullable();
            $table->string('supplier_zip', 10)->nullable();
            $table->bigInteger('supplier_country_id')->unsigned()->nullable();
            $table->bigInteger('payment_term_id')->unsigned()->nullable();
            $table->bigInteger('shipment_term_id')->unsigned()->nullable();
            $table->unsignedBigInteger('pre_purchase_request_id');
            $table->string('email')->nullable();
            $table->text('email_body')->nullable();
            $table->date('required_ship_date')->nullable();
            $table->unsignedBigInteger('requested_by_id');
            $table->text('pre_purchase_terms')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('resend_request')->default(0);
            $table->date('response_ship_date')->nullable();
            $table->text('update_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_purchase_request_supplier_requests');
    }
};
