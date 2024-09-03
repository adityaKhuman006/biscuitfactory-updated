<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class getOutItem extends Model
{
    use HasFactory;

    protected $table = 'get_out_item';

    // Fillable attributes
    protected $fillable = [
        'get_out_id',
        'item_id',
        'quantity',
        'uom_id',
        'rate',
        'amount',
        'remark',
    ];
}
