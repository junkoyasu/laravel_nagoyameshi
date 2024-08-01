<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->category !== null) {
            $shops = Shop::where('category_id', $request->category)->sortable()->paginate(15);
            $total_count = Shop::where('category_id', $request->category)->count();
            $category = Category::find($request->category);
        } else {
            $shops = Shop::sortable()->paginate(15);
            $total_count = "";
            $category = null;
        }

        // $shops = Shop::all();
        $categories = Category::all();

        return view('shops.index', compact('shops', 'category', 'categories','total_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
  
         return view('shops.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->description = $request->input('description');
        $shop->price = $request->input('price');
        $shop->category_id = $request->input('category_id');
        $shop->save();

        return to_route('shops.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $reviews = $shop->reviews()->get();
  
         return view('shops.show', compact('shop', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        $categories = Category::all();
  
         return view('shops.edit', compact('shop', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        $shop->name = $request->input('name');
        $shop->descriotion = $request->input('description');
        $shop->price = $request->input('price');
        $shop->category_id = $request->input('category_id');
        $shop->update();

        return to_route('shops.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $shop->deleate();

        return to_route('shops.index');
    }

    public function favorite(Shop $shop)
     {
         Auth::user()->togglefavorite($shop);
 
         return back();
     }
     public function search(Request $request)
     {
         $keyword = $request->input('keyword');
         
         if ($keyword) {
             $shops = Shop::where('name', 'LIKE', "%{$keyword}%")->get();
         } else {
             $shops = Shop::all();
         }
         $categories = Category::all()->sortBy('category');
         $recently_shops = Shop::orderBy('created_at', 'desc')->take(4)->get();
 
         $recommend_shops = Shop::where('recommend_flag', true)->take(3)->get();
 
         return view('web.index', compact('shops','categories','recently_shops','recommend_shops'));
     }
    //  public function search2(Request $request)
    //  {
    //      $keyword = $request->input('keyword');
         
    //      if ($keyword) {
    //          $shops = Shop::where('name', 'LIKE', "%{$keyword}%")->get();
    //      } else {
    //          $shops = Shop::all();
    //      }
    //      $categories = Category::all()->sortBy('category');
 
    //      return view('shop.index', compact('shops','categories'));
    //  }
}
