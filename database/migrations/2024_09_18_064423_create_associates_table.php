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
        Schema::create('associates', function (Blueprint $table) {
            $table->id();
            $table->string('associate_name');
            $table->string('associate_code')->nullable();
            $table->integer('associate_type_id')->nullable();
            $table->string('contact_name')->nullable();
            $table->integer('referred_by_id')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('accounting_email')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('suite')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('route_id')->nullable();
            $table->integer('primary_sales_id')->nullable();
            $table->integer('secondary_sales_id')->nullable();
            $table->text('internal_notes')->nullable();
            $table->integer('country_id')->nullable();
            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associates');
    }
};
