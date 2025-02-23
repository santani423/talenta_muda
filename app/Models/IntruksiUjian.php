<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntruksiUjian extends Model
{
    public $table = 'intruksi_ujians';
    use HasFactory;
    protected $guarded = ['id'];
}
