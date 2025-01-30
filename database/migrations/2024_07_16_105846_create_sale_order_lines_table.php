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
        Schema::create('sale_order_lines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sales_order_id')->unsigned()->nullable();
            $table->bigInteger('item_id')->unsigned()->nullable();
            $table->bigInteger('so_line_no')->unsigned();
            $table->text('item_description')->nullable();
            $table->float('quantity')->nullable();
            $table->float('unit_price')->nullable();
            $table->float('extended_amount')->nullable();
            $table->boolean('is_taxable')->default(false);
            $table->boolean('is_sold_as')->default(false);
            $table->boolean('is_hideon_print')->default(false);
            $table->boolean('is_not_in_stock')->default(false);
            $table->text('supplier_description')->nullable();
            $table->tinyInteger('line_item')->comment('1: product , 2: service');
            $table->string('pick_ticket_restriction', 10)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_order_lines');
    }
};
