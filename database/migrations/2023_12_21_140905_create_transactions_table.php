<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('cashbill.table_name'), function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('title');
            $table->string('description')->nullable();
            $table->float('amount');
            $table->string('currency_code', 3);
            $table->string('payment_channel')->nullable();
            $table->string('bank_id')->nullable();
            $table->string('status', 30)->default(config('cashbill.default_status'));
            foreach (config('cashbill.personal_data_columns') as $column) {
                $table->string($column)->nullable();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('cashbill.table_name'));
    }
};
