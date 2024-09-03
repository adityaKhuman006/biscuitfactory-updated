<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masterCompany extends Model
{
    use HasFactory;

    protected $table = 'master_company';

    protected $fillable = [
        'compaey_name',
    ];
}
