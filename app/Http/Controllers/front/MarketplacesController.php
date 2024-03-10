<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketplaces;

class MarketplacesController extends Controller
{
    public function index()
    {
        $marketplaces = Marketplaces::all();
        return view('front.marketplaces.index', compact('marketplaces'));
    }
}
