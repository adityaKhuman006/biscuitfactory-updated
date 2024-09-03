<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackMaster extends Model
{
    use HasFactory;

    protected $table = 'pack_masters';

    // Fillable attributes
    protected $fillable = [
        'pack_name',
        'pack_weight',
        'pack_weight_uom',
        'no_pf_packet_polybag',
        'packet_polybag_uom',
        'no_of_polybag_in_cartoon',
        'no_of_cartoon',
        'no_of_cartoon_uom',
        'weight_of_cartoon',
        'weight_of_cartoon_uom',
        'loading_in_container',

        'wrapper_qty',
        'poly_bag_qty',
        'box_qty',
        'tape_qty',
        
    ];
}
