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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('odid')->unique();
            $table->string('date')->nullable()->default('');
            $table->string('last_change_date')->nullable()->default('');
            $table->string('supplier_article')->nullable()->default('');
            $table->string('tech_size')->nullable()->default('');
            $table->string('barcode')->nullable()->default('');
            $table->float('total_price')->nullable()->default(0.00);
            $table->float('discount_percent')->nullable()->default(0.00);
            $table->string('warehouse_name')->nullable()->default('');
            $table->string('oblast')->nullable()->default('');
            $table->integer('income_id')->nullable()->default(0);
            $table->integer('nm_id')->nullable()->default(0);
            $table->string('subject')->nullable()->default('');
            $table->string('category')->nullable()->default('');
            $table->string('brand')->nullable()->default('');
            $table->boolean('is_cancel')->default(false);
            $table->string('cancel_dt')->nullable()->default('');
            $table->string('sticker')->nullable()->default('');
            $table->string('srid')->nullable()->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
