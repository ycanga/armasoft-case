<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stores;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Stores::all();
        return view('front.store.index', compact('stores'));
    }
}
