@extends('layouts.app')
 
 @section('content')
 
 <div class="d-flex justify-content-center">
     <div class="row w-75">
         <div class="col-5 offset-1">
         @if ($shop->image)
             <img src="{{ asset($shop->image) }}" class="w-100 img-fluid">
             @else
             <img src="{{ asset('img/dummy.webp')}}" class="w-100 img-fluid">
             @endif
         </div>
         <div class="col">
             <div class="d-flex flex-column">
                 <h1 class="">
                     {{$shop->name}}
                 </h1>
                 <p class="">
                     {{$shop->description}}
                 </p>
                 <hr>
                 <p class="d-flex align-items-end">
                     ￥{{$shop->price}}
                 </p>
                 <hr>
             </div>
             @auth
             <form method="POST" class="m-3 align-items-end">
                 @csrf
                 <input type="hidden" name="id" value="{{$shop->id}}">
                 <input type="hidden" name="name" value="{{$shop->name}}">
                 <input type="hidden" name="price" value="{{$shop->price}}">
                 
                 <input type="hidden" name="weight" value="0">
                 <div class="row">
                     <div class="col-7">
                        
                        @if(Auth::check() && Auth::user()->token)
                         <a href="{{ route('shops.reservations.create', $shop) }}" class="btn btn-primary">予約する</a>
                        @else
                         <p>有料会員のみ予約が可能です。<a href="{{ route('mypage.register_card') }}">こちらから有料会員に登録</a>。</p>
                        @endif
                     
                    
                     </div>
                     <div class="col-5">
                     @if(Auth::check() && Auth::user()->token)
                     @if($shop->isFavoritedBy(Auth::user()))
                         <a href="{{ route('shops.favorite', $shop) }}" class="btn nagoyameshi-favorite-button text-favorite w-100">
                             <i class="fa fa-heart"></i>
                             お気に入り解除
                         </a>
                         @else
                         <a href="{{ route('shops.favorite', $shop) }}" class="btn nagoyameshi-favorite-button text-favorite w-100">
                             <i class="fa fa-heart"></i>
                             お気に入り
                         </a>
                         @endif
                         
                        @else
                         <p>有料会員のみお気に入りが可能です。<a href="{{ route('mypage.register_card') }}">こちらから有料会員に登録</a>。</p>
                        @endif
                     
                     </div>
                 </div>
             </form>
             @endauth
         </div>
 
         <div class="offset-1 col-11">
             <hr class="w-100">
             <h3 class="float-left">カスタマーレビュー</h3>
         </div>
 
         <div class="offset-1 col-10">
             
             <div class="row">
                 @foreach($reviews as $review)
                 <div class="offset-md-5 col-md-5">
                 <h3 class="review-score-color">{{ str_repeat('★', $review->score) }}</h3>
                     <p class="h3">{{$review->content}}</p>
                     <label>{{$review->created_at}} {{$review->user->name}}</label>
                 </div>
                 @endforeach
             </div><br />
 
             @auth
             <div class="row">
                 <div class="offset-md-5 col-md-5">
                     <form method="POST" action="{{ route('reviews.store') }}">
                         @csrf
                         <h4>評価</h4>
                         <select name="score" class="form-control m-2 review-score-color">
                             <option value="5" class="review-score-color">★★★★★</option>
                             <option value="4" class="review-score-color">★★★★</option>
                             <option value="3" class="review-score-color">★★★</option>
                             <option value="2" class="review-score-color">★★</option>
                             <option value="1" class="review-score-color">★</option>
                         </select>
                         <h4>レビュー内容</h4>
                         @error('content')
                             <strong>レビュー内容を入力してください</strong>
                         @enderror
                         <textarea name="content" class="form-control m-2"></textarea>
                         <input type="hidden" name="shop_id" value="{{$shop->id}}">
                         @if(Auth::check() && Auth::user()->token)
                         <button type="submit" class="btn nagoyameshi-submit-button ml-2">レビューを追加</button>
                        @else
                         <p>有料会員のみレビューを投稿が可能です。<a href="{{ route('mypage.register_card') }}">こちらから有料会員に登録</a>。</p>
                        @endif
                         
                     </form>
                 </div>
             </div>
             @endauth
         </div>
     </div>
 </div>
 @endsection