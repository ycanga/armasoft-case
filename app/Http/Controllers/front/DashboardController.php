<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Marketplaces;
use App\Models\Stores;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Products::count();
        $categories = Categories::count();
        $marketplaces = Marketplaces::count();
        $stores = Stores::count();
        return view('front.dashboard', compact('products', 'categories', 'marketplaces', 'stores'));
    }
}
