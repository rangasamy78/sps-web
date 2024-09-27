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
        Schema::create('tax_codes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sort_order')->unsigned()->nullable();
            $table->string('code')->nullable();
            $table->string('label')->nullable();
            $table->text('notes')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('is_purchase_tax')->nullable();
            $table->string('is_sales_tax')->nullable();
            $table->string('is_use_tax')->nullable();
            $table->string('tax_item')->nullable();
            $table->string('tax_item_id')->nullable();
            $table->string('rate')->nullable();
            $table->date('effective_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_codes');
    }
};
