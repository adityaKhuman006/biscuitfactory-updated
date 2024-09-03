<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiscuitMaster extends Model
{
    use HasFactory;
    protected $table = 'biscuit_masters';

    protected $fillable = [
        'name',
        'img',
    ];
}
