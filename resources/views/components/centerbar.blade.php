<div class="container">
<h1 class="h1-category">カテゴリー検索</h1>
 @foreach ($categories as $category)
 
 
 <label class="nagoyameshi-centerbar-category-label"><a href="{{ route('shops.index', ['category' => $category->id]) }}">{{ $category->name }}</a></label>
 @endforeach
</div>