<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulatorUjianPg extends Model
{
    use HasFactory;
    public $table = 'simulai_ujan_pg';
    protected $guarded = ['id'];
}
