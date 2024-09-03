<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemsMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "type",
        "uom",
        "uom2",
        "remark",
    ];
}
