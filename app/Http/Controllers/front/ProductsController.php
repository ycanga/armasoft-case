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
            ->select('products.*', 'product_images.image_url', 'categories.name as category_name')
            ->get();

        return view('front.products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = DB::table('products')
            ->join('product_images', 'products.id', '=', 'product_images.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('stores', 'products.store_id', '=', 'stores.id')
            ->join('marketplaces', 'products.marketplace_id', '=', 'marketplaces.id')
            ->join('issues', 'products.id', '=', 'issues.product_id')
            ->join('product_listings', 'products.id', '=', 'product_listings.product_id')
            ->select('products.*', 'product_images.image_url', 'categories.name as category_name', 'stores.name as store_name', 'marketplaces.name as marketplace_name', 'issues.details as issue_details', 'issues.status as issue_status', 'product_listings.barcode as listing_barcode', 'product_listings.f_channel as listing_f_channel', 'product_listings.browse_node as listing_browse_node')
            ->where('products.slug', $slug)
            ->first();

        return view('front.products.show', compact('product'));
    }
}
