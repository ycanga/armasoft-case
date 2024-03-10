<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
        return view('front.categories.index', compact('categories'));
    }
}
