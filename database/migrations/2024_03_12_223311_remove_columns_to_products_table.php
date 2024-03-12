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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('marketplace_category');
            $table->dropColumn('marketplace_qty');
            $table->dropColumn('marketplace_price');
            $table->dropColumn('marketplace_sale_price');
            $table->dropColumn('marketplace_listing_number');
            $table->dropColumn('marketplace_handling');
            $table->dropColumn('marketplace_status');
            $table->dropColumn('currency_smybol');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('marketplace_category')->nullable();
            $table->string('marketplace_qty')->nullable();
            $table->string('marketplace_price')->nullable();
            $table->string('marketplace_sale_price')->nullable();
            $table->string('marketplace_listing_number')->nullable();
            $table->string('marketplace_handling')->nullable();
            $table->string('marketplace_status')->nullable();
            $table->string('currency_smybol')->nullable();
        });
    }
};
