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
        Schema::create('print_doc_disclaimers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('select_type_category_id');
            $table->unsignedBigInteger('select_type_sub_category_id')->nullable();
            $table->text('policy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_doc_disclaimers');
    }
};
