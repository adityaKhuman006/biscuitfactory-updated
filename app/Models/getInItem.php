<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class getInItem extends Model
{
    use HasFactory;

    protected $table = 'get_in_item';

    // Fillable attributes
    protected $fillable = [
        'get_in_id',
        'item_id',
        'quantity',
        'uom_id',
        'rate',
        'amount',
        'remark',
    ];
}
