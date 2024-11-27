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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('entered_by_id');
            $table->integer('event_type_id')->nullable();
            $table->date('schedule_date')->nullable();
            $table->time('schedule_time')->nullable();
            $table->integer('assigned_to_id');
            $table->string('follower_id')->nullable();
            $table->string('event_title')->nullable();
            $table->string('party_name')->nullable();
            $table->string('product_id')->nullable();
            $table->decimal('price')->nullable();
            $table->text('description')->nullable();
            $table->string('type');
            $table->integer('type_id');
            $table->boolean('mark_as_complete')->default(false);
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
