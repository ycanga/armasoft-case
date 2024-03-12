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
        Schema::create('marketplace_details', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable();
            $table->string('marketplace_category')->nullable();
            $table->string('marketplace_qty')->nullable();
            $table->string('marketplace_price')->nullable();
            $table->string('marketplace_sale_price')->nullable();
            $table->string('marketplace_listing_number')->nullable();
            $table->string('marketplace_handling')->nullable();
            $table->string('marketplace_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplace_details');
    }
};
