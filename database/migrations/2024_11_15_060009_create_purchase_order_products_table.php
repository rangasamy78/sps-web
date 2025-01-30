<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('po_id');
            $table->unsignedBigInteger('product_id');
            $table->string('so')->nullable();
            $table->unsignedInteger('purchased_as')->nullable();
            $table->text('description')->nullable();
            $table->text('supplier_purchasng_note')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('bundles')->nullable();
            $table->integer('slab_bundles')->nullable();
            $table->integer('slab')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->decimal('extended', 10, 2)->nullable();
            $table->string('sipl_created')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_products');
    }
};