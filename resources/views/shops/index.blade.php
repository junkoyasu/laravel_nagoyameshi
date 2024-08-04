@extends('layouts.app')
 
 @section('content')
  
 <div class="row" >
 <div class="col-12 col-md-8" id="container-shop">
         @component('components.centerbar', ['categories' => $categories])
         @endcomponent
     </div>
</div>
     <div class="col-12">
     <div class="container">
             @if ($category !== null)
                 <a href="{{ route('shops.index') }}"></a> 
                 <h1>{{ $category->name }}の店舗一覧{{$total_count}}件</h1>
             @endif
             <ul id="container-itirann">
                        @foreach($shops as $shop)
                        <div class="col-4">
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
             
 @endsection