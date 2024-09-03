<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transferMaterial extends Model
{
    use HasFactory;

    protected $table = 'transfer_material';

    protected $fillable = [
        'date',
        'time',
        'item_images',
    ];
}
