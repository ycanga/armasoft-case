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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('marketplace_id')->nullable();
            $table->string('marketplace_category')->nullable();
            $table->string('marketplace_qty')->nullable();
            $table->string('marketplace_price')->nullable();
            $table->string('marketplace_sale_price')->nullable();
            $table->string('marketplace_listing_number')->nullable();
            $table->string('marketplace_handling')->nullable();
            $table->string('marketplace_status')->nullable();
            $table->string('has_offers')->nullable();
            $table->string('is_linked')->nullable();
            $table->string('is_on_sale')->nullable();
            $table->string('asin')->nullable();
            $table->string('publish_status')->nullable();
            $table->string('item_page_url')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_smybol')->nullable();


            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('marketplace_id')->references('id')->on('marketplaces');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
