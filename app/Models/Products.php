<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Tüm relationlar devredışı bırakıldı.
    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->hasMany(Categories::class, 'id', 'category_id');
    }

    public function store()
    {
        return $this->hasMany(Stores::class, 'id', 'store_id');
    }

    public function marketplaces()
    {
        return $this->hasMany(Marketplaces::class, 'id', 'marketplace_id');
    }

    public function issues()
    {
        return $this->hasMany(Issues::class, 'product_id', 'id');
    }

    public function listings()
    {
        return $this->hasMany(ProductListings::class, 'product_id', 'id');
    }
}
