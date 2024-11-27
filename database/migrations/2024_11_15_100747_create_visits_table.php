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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opportunity_id'); // Foreign key referencing the opportunities table
            $table->string('visit_label')->nullable();
            $table->date('visit_date')->nullable();
            $table->time('visit_time')->nullable();
            $table->unsignedBigInteger('sales_person_id')->nullable(); // Foreign key referencing the users table
            $table->unsignedBigInteger('price_level_id')->nullable(); // Foreign key referencing price levels
            $table->text('visit_printed_notes')->nullable();
            $table->unsignedBigInteger('probability_close_id')->nullable(); // Foreign key referencing probabilities
            $table->text('survey_rating')->nullable();
            $table->boolean('checkout')->default(false); // Default value for a boolean field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
