<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acquisition extends Model
{
    /** @use HasFactory<\Database\Factories\AcquisitionFactory> */
    use HasFactory;

    protected $fillable = [
        'nip',
        'name',
        'position',
        'product',
        'branch_id',
        'month',
        'customer',
        'year',
    ];
}
