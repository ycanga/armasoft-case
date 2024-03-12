<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketplaceDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'marketplace_category',
        'marketplace_qty',
        'marketplace_price',
        'marketplace_sale_price',
        'marketplace_listing_number',
        'marketplace_handling',
        'marketplace_status',
    ];
}
