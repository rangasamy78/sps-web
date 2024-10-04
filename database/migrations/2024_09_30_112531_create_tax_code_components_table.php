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
        Schema::create('tax_code_components', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tax_code_id')->nullable();
            $table->bigInteger('tax_component_id')->nullable();
            $table->string('gl_account_name')->nullable();
            $table->decimal('rate', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_code_components');
    }
};
