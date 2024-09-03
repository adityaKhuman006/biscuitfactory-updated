<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItems extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "item_id",
        "recipie_weight",
        "uom",
    ];
}
