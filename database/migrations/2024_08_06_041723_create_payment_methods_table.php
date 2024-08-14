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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method_name');
            $table->integer('linked_account_id')->nullable();
            $table->integer('account_type_id')->nullable();
            $table->tinyInteger('is_transaction_required')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
