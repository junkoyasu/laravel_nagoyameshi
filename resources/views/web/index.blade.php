@extends('layouts.app')
 
 @section('content')
 
    <div class="top-container">
        <img src="{{ asset('img/udon.jpg')}}" class="top-image" >
        <p class="top-font">名古屋ならではの味を、<br>見つけよう</p>
    </div>
    <div class="row">
 <div class="bg-light mb-4 py-4">
        <div class="container nagoyameshi-container" id="container-search">
            <h2 class="mb-3">店舗検索</h2>
            <form method="GET" action="{{ route('shop.search') }}" class="nagoyameshi-user-search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="店舗名で検索" name="keyword">
                    <button type="submit" class="btn text-green shadow-sm nagoyameshi-btn" id="search-btn">検索</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
            @if(isset($shops))
                <h2 class="mb-3">検索結果</h2>
                @if(count($shops) > 0)
                    <ul>
                        @foreach($shops as $shop)
                        <div class="col-3">
                     <a href="{{route('shops.show', $shop)}}">
                     @if ($shop->image !== "")
                         <img src="{{ asset($shop->image) }}" class="img-thumbnail">
                         @else
                         <img src="{{ asset('img/dummy.webp')}}" class="img-thumbnail">
                         @endif
                        </a>
                        <div class="row">
                         <div class="col-12">
                             <p class="nagoyameshi-shop-label mt-2">
                                 {{$shop->name}}<br>
                                 <label>￥{{$shop->price}}</label>
                             </p>
                         </div>
                     </div>
                        @endforeach
                    </ul>
                    </div>
                @else
                    <p>該当する店舗は見つかりませんでした。</p>
                @endif
            @endif
        </div>
        
    </div>
      <div class="bg-light mb-4 py-4">
         @component('components.centerbar', ['categories' => $categories])
         @endcomponent
     </div> 
     <!-- <div class="col-6"> -->
    
     <!-- </div> -->
     <div class="col-9">
         <h1>おすすめ店舗</h1>
         <div class="row">
         @foreach ($recommend_shops as $recommend_shop)
             <div class="col-4">
                 <a href="{{ route('shops.show', $recommend_shop) }}">
                     @if ($recommend_shop->image !== "")
                     <img src="{{ asset($recommend_shop->image) }}" class="img-thumbnail">
                     @else
                     <img src="{{ asset('img/dummy.webp')}}" class="img-thumbnail">
                     @endif
                 </a>
                 <div class="row">
                     <div class="col-12">
                         <p class="nagoyameshi-shop-label mt-2">
                             {{ $recommend_shop->name }}<br>
                             <label>￥{{ $recommend_shop->price }}</label>
                         </p>
                     </div>
                 </div>
             </div>
             @endforeach
 
         </div>
 
         <h1>新着店舗</h1>
         <div class="row">
         @foreach ($recently_shops as $recently_shop)
             <div class="col-3">
                 <a href="{{ route('shops.show', $recently_shop) }}">
                     @if ($recently_shop->image !== "")
                     <img src="{{ asset($recently_shop->image) }}" class="img-thumbnail">
                     @else
                     <img src="{{ asset('img/dummy.webp')}}" class="img-thumbnail">
                     @endif
                 </a>
                 <div class="row">
                     <div class="col-12">
                         <p class="nagoyameshi-shop-label mt-2">
                             {{ $recently_shop->name }}<br>
                             <label>￥{{ $recently_shop->price }}</label>
                         </p>
                     </div>
                 </div>
             </div>
         @endforeach
         </div>
     </div>
 </div>
 @endsection