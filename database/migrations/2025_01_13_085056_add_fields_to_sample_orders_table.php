<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\After;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sample_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('price_level_id')->nullable()->after('sales_person_id');
            $table->unsignedBigInteger('end_use_segment_id')->nullable()->after('price_level_id');
            $table->unsignedBigInteger('project_type_id')->nullable()->after('end_use_segment_id');
            $table->string('delivery_phone', 50)->nullable()->after('delivery_zip');
            $table->string('delivery_fax', 50)->nullable()->after('delivery_phone');
            $table->string('delivery_email', 100)->nullable()->after('delivery_fax');
            $table->string('delivery_shipping_ui', 100)->nullable()->after('delivery_tracking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sample_orders', function (Blueprint $table) {
            //
        });
    }
};
