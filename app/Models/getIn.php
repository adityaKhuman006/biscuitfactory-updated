<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class getIn extends Model
{
    use HasFactory;

    protected $table = 'get_in';

    // Fillable attributes
    protected $fillable = [
        'type_id',
        'date',
        'time',
        'company_id',
        'location',
        'inv_challan_number',
        'inv_challan_date',
        'vehicle_number',
        'mobile',
        'img',
    ];
}
