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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_id')->unique();
            $table->string('g_number')->nullable();
            $table->string('date')->nullable();
            $table->string('last_change_date')->nullable();
            $table->string('supplier_article')->nullable();
            $table->string('tech_size')->nullable();
            $table->string('barcode')->nullable();
            $table->float('total_price')->nullable();
            $table->float('discount_percent')->nullable();
            $table->boolean('is_supply')->default(false);
            $table->boolean('is_realization')->default(false);
            $table->float('promo_code_discount')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->string('country_name')->nullable();
            $table->string('oblast_okrug_name')->nullable();
            $table->string('region_name')->nullable();
            $table->float('income_id')->nullable();
            $table->string('sale_dt')->nullable();
            $table->float('for_pay')->nullable();
            $table->float('finished_price')->nullable();
            $table->float('price_with_disc')->nullable();
            $table->integer('is_storno')->default(0);
            $table->string('sticker')->nullable();
            $table->string('srid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
