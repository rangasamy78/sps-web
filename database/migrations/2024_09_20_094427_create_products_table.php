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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_sku')->nullable();
            $table->integer('product_kind_id');
            $table->text('product_alternate_name')->nullable();
            $table->integer('product_type_id');
            $table->integer('product_base_color_id')->nullable();
            $table->integer('product_category_id')->nullable();
            $table->integer('product_origin_id')->nullable();
            $table->integer('product_sub_category_id')->nullable();
            $table->integer('product_group_id')->nullable();
            $table->integer('product_thickness_id')->nullable();
            $table->integer('product_finish_id')->nullable();
            $table->string('product_series_name')->nullable();
            $table->integer('unit_of_measure_id');
            $table->string('product_weight')->nullable();
            $table->string('product_size')->nullable();
            $table->boolean('indivisible')->default(0);
            $table->boolean('manufactured')->default(0);
            $table->boolean('generic')->default(0);
            $table->boolean('select_slab')->default(0);
            $table->integer('gl_inventory_link_account_id');
            $table->integer('gl_income_account_id');
            $table->integer('gl_cogs_account_id');
            $table->string('safety_stock')->nullable();
            $table->string('safety_stock_value')->nullable();
            $table->string('reorder_qty')->nullable();
            $table->string('reorder_qty_value')->nullable();
            $table->string('lead_time')->nullable();
            $table->integer('assign_bin_id')->nullable();
            $table->integer('preferred_supplier_id')->nullable();
            $table->string('brand_or_manufacturer_id')->nullable();
            $table->string('generic_name')->nullable();
            $table->string('generic_sku')->nullable();
            $table->integer('purchasing_unit_id')->nullable();
            $table->string('purchasing_unit_cost')->nullable();
            $table->float('avg_est_cost')->nullable();
            $table->integer('uom_one_id')->nullable();
            $table->string('uom_one_value')->nullable();
            $table->integer('uom_two_id')->nullable();
            $table->string('uom_two_value')->nullable();
            $table->integer('uom_three_id')->nullable();
            $table->string('uom_three_value')->nullable();
            $table->integer('uom_four_id')->nullable();
            $table->string('uom_four_value')->nullable();
            $table->integer('uom_five_id')->nullable();
            $table->string('uom_five_value')->nullable();
            $table->integer('uom_six_id')->nullable();
            $table->string('uom_six_value')->nullable();
            $table->integer('minimum_packing_unit_id')->nullable();
            $table->string('minimum_packing_unit_value')->nullable();
            $table->boolean('new_product_flag')->default(0);
            $table->boolean('hide_on_website_or_guest_book')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->string('web_user_name')->nullable();
            $table->text('description_on_web')->nullable();
            $table->text('notes')->nullable();
            $table->text('special_intstruction')->nullable();
            $table->text('disclaimer')->nullable();

            $table->enum('color_enhancing', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('countertop_vanities', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('interior_floor', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('fireplace_interior_wall', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('shower_wall', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('shower_floor', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('exterior_floor', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('exterior_wall', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('pool_fountain', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('furniture_top', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('translucent', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('cut_to_size', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('sealer', ['Yes', 'No', 'N/A'])->nullable();
            $table->enum('abrasion_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('stain_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('etching_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('heat_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('uv_resistance', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('color_range', ['Low', 'Medium', 'High'])->nullable();
            $table->enum('movement_index', ['Low', 'Medium', 'High'])->nullable();
            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
