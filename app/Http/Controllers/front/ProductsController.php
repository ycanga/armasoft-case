<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('marketplace_details', 'products.marketplace_details_id', '=', 'marketplace_details.id')
            ->join('currencies', 'products.currency', '=', 'currencies.id')
            ->select('products.*', 'product_images.image_url', 'categories.name as category_name', 'currencies.symbol as currency_symbol', 'marketplace_details.marketplace_category', 'marketplace_details.marketplace_qty', 'marketplace_details.marketplace_price', 'marketplace_details.marketplace_sale_price', 'marketplace_details.marketplace_listing_number', 'marketplace_details.marketplace_handling', 'marketplace_details.marketplace_status')
            ->get();

        return view('front.products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = DB::table('products')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('stores', 'products.store_id', '=', 'stores.id')
            ->join('marketplaces', 'products.marketplace_id', '=', 'marketplaces.id')
            ->join('marketplace_details', 'products.marketplace_details_id', '=', 'marketplace_details.id')
            ->leftJoin('issues', 'products.id', '=', 'issues.product_id')
            ->join('product_listings', 'products.id', '=', 'product_listings.product_id')
            ->join('currencies', 'products.currency', '=', 'currencies.id')
            ->select('products.*', 'product_images.image_url', 'categories.name as category_name', 'stores.name as store_name', 'marketplaces.name as marketplace_name', 'marketplace_details.marketplace_category', 'marketplace_details.marketplace_qty', 'marketplace_details.marketplace_price', 'marketplace_details.marketplace_sale_price', 'marketplace_details.marketplace_listing_number', 'marketplace_details.marketplace_handling', 'marketplace_details.marketplace_status', 'issues.details as issue_details', 'issues.status as issue_status', 'product_listings.barcode as listing_barcode', 'product_listings.f_channel as listing_f_channel', 'product_listings.browse_node as listing_browse_node', 'currencies.symbol as currency_symbol')
            ->where('products.slug', $slug)
            ->first();

        return view('front.products.show', compact('product'));
    }
}
