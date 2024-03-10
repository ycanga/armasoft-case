<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::with(['images', 'category'])->get();
        return view('front.products.index', compact('products'));
    }

    public function show($slug)
    {
        $product = Products::with(['images', 'category', 'store', 'marketplaces', 'issues', 'listings'])->where('slug', $slug)->first();
        return view('front.products.show', compact('product'));
    }
}
