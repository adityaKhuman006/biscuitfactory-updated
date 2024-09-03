<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product',
        'brand_name',
        'pack_size',
        'qty_container',
        'reqd_oty',
        'container_date',
        'container_booked',
        'die_name',

        // 'hide',
        'wrapper_design',
        'box_design',
        'approval_from_customer',
    ];

    const YES = 1;
    const NO = 2;


    function Products(){
        return $this->hasMany(ProductMaster::class, 'id', 'product');
    }
}
