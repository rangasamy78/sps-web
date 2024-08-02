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
        Schema::create('supplier_cost_list_labels', function (Blueprint $table) {
            $table->id();
            $table->string('cost_level');
            $table->string('cost_code')->nullable();
            $table->string('cost_label');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_cost_list_labels');
    }
};
