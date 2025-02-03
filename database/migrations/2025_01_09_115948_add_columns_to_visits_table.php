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
        Schema::table('visits', function (Blueprint $table) {
            $table->unsignedBigInteger('end_use_segment_id')->nullable()->after('price_level_id'); // Foreign key referencing price levels
            $table->unsignedBigInteger('project_type_id')->nullable()->after('end_use_segment_id'); // Foreign key referencing price levels
            $table->text('visit_internal_notes')->nullable()->after('visit_printed_notes');
            $table->decimal('total', 8, 2)->nullable()->after('checkout');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            //
        });
    }
};
