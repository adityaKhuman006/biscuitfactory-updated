<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeMaster extends Model
{
    use HasFactory;

    protected $table = 'master_employe';

    protected $fillable = [
        'name',
    ];
}
