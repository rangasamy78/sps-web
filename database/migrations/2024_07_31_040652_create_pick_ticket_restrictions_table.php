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
        Schema::create('pick_ticket_restrictions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('enable_pick_ticket_restriction');
            $table->tinyInteger('default_pick_ticket_restriction');
            $table->tinyInteger('pick_ticket_restriction_required');
            $table->tinyInteger('default_lot_restriction_based_on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pick_ticket_restrictions');
    }
};
