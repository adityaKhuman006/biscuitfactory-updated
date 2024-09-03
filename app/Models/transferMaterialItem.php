<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transferMaterialItem extends Model
{
    use HasFactory;
    protected $table = 'transfer_material_item';

    // Fillable attributes
    protected $fillable = [
        'transfer_material_id',
        'item',
        'quantity',
        'uom',
        'from',
        'to',
        'person',
        'remark',
    ];
}
