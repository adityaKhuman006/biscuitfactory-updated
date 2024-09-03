<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mainOrderItem extends Model
{
    use HasFactory;
    protected $table = 'main_order_item';

    // Fillable attributes
    protected $fillable = [
        'mainOrder_id',
        'item',
        'item_id',
        'quantity',
        'uom',
    ];
}
