<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mainOrder extends Model
{
    use HasFactory;

    protected $table = 'main_order';

    // Fillable attributes
    protected $fillable = [
        'product_name',
        'date',
        'batch_size',
        'batch_required',
    ];
}
