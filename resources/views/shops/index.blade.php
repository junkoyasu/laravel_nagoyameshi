@extends('layouts.app')
 
 @section('content')
  <!--  
 <div>
        <div class="swiper nagoyameshi-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{ asset('/img/main1.jpg') }}"></div>
                <div class="swiper-slide"><img src="{{ asset('/img/main2.jpg') }}"></div>
                <div class="swiper-slide"><img src="{{ asset('/img/main3.jpg') }}"></div>
                <div class="d-flex align-items-center nagoyameshi-overlay-background">
                    <div class="container nagoyameshi-container nagoyameshi-overlay-text">
                        <h1 class="text-white nagoyameshi-catchphrase-heading">名古屋ならではの味を、<br>見つけよう</h1>
                        <p class="text-white nagoyameshi-catchphrase-paragraph">NAGOYAMESHIは、<br>名古屋市のB級グルメ専門のレビューサイトです。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
 <div class="row">
 <div class="col-12 col-md-8">
         @component('components.centerbar', ['categories' => $categories])
         @endcomponent
     </div>
</div>
     <div class="col-9">
     <div class="container">
             @if ($category !== null)
                 <a href="{{ route('shops.index') }}">トップ</a> > <a href="#">{{ $category->name }}</a> > 
                 <h1>{{ $category->name }}の店舗一覧{{$total_count}}件</h1>
             @endif
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
                        @endforeach
             <!-- <div class="bg-light mb-4 py-4"> 
        <div class="container nagoyameshi-container">
            <h2 class="mb-3">店舗検索</h2>
            <form method="GET" action="{{ route('shop.search') }}" class="nagoyameshi-user-search-box">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="店舗名で検索" name="keyword">
                    <button type="submit" class="btn text-white shadow-sm nagoyameshi-btn" id="seach-btn">検索</button>
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
        
         </div> -->
         <!-- <div>
             Sort By
             @sortablelink('id', 'ID')
             @sortablelink('price', 'Price')
         </div> -->
         <!-- <div class="container mt-4">
             <div class="row w-100">
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
                 </div>
                 @endforeach
             </div>
         </div>
      
     </div>
 </div> -->
 @endsection