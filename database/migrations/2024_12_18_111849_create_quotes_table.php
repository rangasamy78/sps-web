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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opportunity_id');
            $table->string('quote_label')->nullable();
            $table->date('quote_date')->default(DB::raw('CURRENT_DATE'));
            $table->time('quote_time')->nullable();
            $table->date('expiry_date')->default(DB::raw('CURRENT_DATE'));
            $table->string('customer_po', 50)->nullable();
            $table->unsignedBigInteger('price_level_id');
            $table->unsignedBigInteger('end_use_segment_id')->nullable();
            $table->unsignedBigInteger('project_type_id')->nullable();
            $table->date('eta_date')->nullable();
            $table->unsignedBigInteger('payment_terms_id');
            $table->unsignedBigInteger('sales_tax_id');
            $table->unsignedBigInteger('secondary_sales_person_id')->nullable();
            $table->unsignedBigInteger('quote_header_id')->nullable();
            $table->unsignedBigInteger('quote_footer_id')->nullable();
            $table->unsignedBigInteger('quote_printed_notes_id')->nullable();
            $table->text('quote_printed_note')->nullable();
            $table->text('quote_internal_note')->nullable();
            $table->unsignedBigInteger('probability_close_id')->nullable();
            $table->text('survey_rating')->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
