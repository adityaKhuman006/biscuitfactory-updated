<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masterProduct extends Model
{
    use HasFactory;

    protected $table = 'master_product';

    // Fillable attributes
    protected $fillable = [
        'product_name',
        'type',
        'uom',
        'packing',
        'remark'
    ];
}
