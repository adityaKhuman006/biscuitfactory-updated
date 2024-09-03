<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMaster extends Model
{
    use HasFactory;

    protected $table = 'type_masters';

    protected $fillable = [
        "short_name",
        "full_name"
    ];

}
