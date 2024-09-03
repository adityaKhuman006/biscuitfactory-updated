<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masterAccount extends Model
{
    use HasFactory;

    protected $table = 'master_account';

    protected $fillable = [
        'name',
        'address',
        'type',
    ];


    const CUSTOMER = 1;
    const EMPLOYE = 2;
    const VENDOR = 3;
    const OTHER = 4;
}
