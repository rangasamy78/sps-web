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
        Schema::create('quote_receive_deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('cash_account_id');
            $table->string('receipt_code')->nullable();
            $table->date('deposit_date')->default(DB::raw('CURRENT_DATE'));;
            $table->unsignedBigInteger('payment_method_id');
            $table->string('reference')->nullable();
            $table->date('reference_date')->nullable();
            $table->string('authorization')->nullable();
            $table->date('check_date')->nullable();
            $table->string('check_code')->nullable();
            $table->decimal('receive_amount', 10, 2)->nullable();
            $table->decimal('net_amount_due', 10, 2)->nullable();
            $table->enum('quote_amount_percentage', ['20', '25', '30', '40', '50', '100'])->nullable();
            $table->string('address', 250)->nullable();
            $table->string('suite', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 150)->nullable();
            $table->string('zip', 100)->nullable();
            $table->string('memo', 200)->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_receive_deposits');
    }
};
