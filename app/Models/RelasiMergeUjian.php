<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelasiMergeUjian extends Model
{
    use HasFactory;
    public $table = 'relasi_ujian_merge';
    protected $guarded = ['id'];
}
