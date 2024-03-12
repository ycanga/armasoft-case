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
        Schema::create('product_listings', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable()->index();
            $table->string('quantity')->nullable();
            $table->string('price')->nullable();
            $table->string('sale_price')->nullable();
            $table->string('title')->nullable();
            $table->string('barcode')->nullable();
            $table->string('f_channel')->nullable();
            $table->string('browse_node')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_listings');
    }
};
