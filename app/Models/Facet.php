<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facet extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'deskripsi',
    ];
}
