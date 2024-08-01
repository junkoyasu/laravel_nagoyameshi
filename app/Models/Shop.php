<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Kyslik\ColumnSortable\Sortable;

class Shop extends Model
{
    use HasFactory, Favoriteable, Sortable;
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
        'recommend_flag',
        
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasmany(Review::class);
    }

    public function reservations()
    {
        return $this->hasmany(Reservation::class);
    }
}
