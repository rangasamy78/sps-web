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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('event_type_id');
            $table->integer('entered_by_id');
            $table->date('schedule_date')->nullable();
            $table->integer('assigned_to_id');
            $table->time('schedule_time')->nullable();
            $table->string('follower_id')->nullable();
            $table->string('event_title');
            $table->string('party_name')->nullable();
            $table->integer('party_name_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('price')->nullable();
            $table->text('description')->nullable();
            $table->integer('mark_as_complete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
