<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sample_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opportunity_id');
            $table->string('sample_order_label')->nullable();
            $table->date('sample_order_date')->default(DB::raw('CURRENT_DATE'));
            $table->time('sample_order_time')->nullable();
            $table->unsignedBigInteger('sales_person_id')->nullable();
            $table->enum('delivery_type', ['pickup', 'delivery'])->nullable();
            $table->string('delivery_attn', 50)->nullable();
            $table->string('delivery_tracking', 100)->nullable();
            $table->string('delivery_address', 250)->nullable();
            $table->string('delivery_suite', 150)->nullable();
            $table->string('delivery_city', 100)->nullable();
            $table->string('delivery_state', 100)->nullable();
            $table->string('delivery_zip', 50)->nullable();
            $table->unsignedBigInteger('delivery_country_id')->nullable();
            $table->unsignedBigInteger('delivery_county_id')->nullable();
            $table->unsignedBigInteger('document_footer_id')->nullable();
            $table->text('sample_order_printed_notes')->nullable();
            $table->text('sample_order_special_instructions')->nullable();
            $table->unsignedBigInteger('probability_close_id')->nullable();
            $table->enum('status', ['initiate', 'shipped', 'closed'])->default('initiate');
            $table->decimal('total', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_orders');
    }
};
