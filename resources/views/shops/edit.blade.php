@extends('layouts.app')
 
 @section('content')
 <div class="container">
     <h1>お店情報更新</h1>
 
     <form action="{{ route('shops.update',$shop->id) }}" method="POST">
         @csrf
         @method('PUT')
         <div class="form-group">
             <label for="shop-name">お店名</label>
             <input type="text" name="name" id="shop-name" class="form-control" value="{{ $shop->name }}">
         </div>
         <div class="form-group">
             <label for="shop-description">お店説明</label>
             <textarea name="description" id="shop-description" class="form-control">{{ $shop->description }}</textarea>
         </div>
         <div class="form-group">
             <label for="shop-price">価格</label>
             <input type="number" name="price" id="shop-price" class="form-control" value="{{ $shop->price }}">
         </div>
         <div class="form-group">
             <label for="shop-category">カテゴリ</label>
             <select name="category_id" class="form-control" id="shop-category">
                 @foreach ($categories as $category)
                 @if ($category->id == $shop->category_id)
                 <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                 @else
                 <option value="{{ $category->id }}">{{ $category->name }}</option>
                 @endif
                 @endforeach
             </select>
         </div>
         <button type="submit" class="btn btn-danger">更新</button>
     </form>
 
     <a href="{{ route('shops.index') }}">お店一覧に戻る</a>
 </div>
 @endsection
