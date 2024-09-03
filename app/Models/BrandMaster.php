<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandMaster extends Model
{
    use HasFactory;

    protected $table = 'master_brand';

    protected $fillable = [
        'name',
        'type',
        'owner',
    ];

    const ITEM = 1;
    const PRODUCT = 2;

}
