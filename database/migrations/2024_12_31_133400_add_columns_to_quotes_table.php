<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->date('status_update_date')->default(DB::raw('CURRENT_DATE'))->after('total');
            $table->unsignedBigInteger('status_update_user_id')->after('status_update_date');
            $table->text('notes')->nullable()->after('status_update_user_id');
            $table->enum('status', ['open', 'close'])->default('open')->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            //
        });
    }
};
