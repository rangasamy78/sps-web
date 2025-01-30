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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('inventory_in_stock')->default(0)->after('status');   
            $table->integer('inventory_committed')->default(0)->after('inventory_in_stock');
            $table->integer('inventory_available')->default(0)->after('inventory_committed'); 
            $table->date('received_date')->nullable()->after('inventory_available'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'inventory_in_stock',
                'inventory_committed',
                'inventory_available',
                'received_date',
            ]);
        });
    }
};
