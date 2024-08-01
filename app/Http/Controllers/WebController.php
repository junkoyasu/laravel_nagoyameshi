<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Shop;

class WebController extends Controller
{
    public function index()
    {
        $categories = Category::all()->sortBy('category');
        $recently_shops = Shop::orderBy('created_at', 'desc')->take(4)->get();

        $recommend_shops = Shop::where('recommend_flag', true)->take(3)->get();


       
        return view('web.index', compact('categories', 'recently_shops', 'recommend_shops'));
    }
}
