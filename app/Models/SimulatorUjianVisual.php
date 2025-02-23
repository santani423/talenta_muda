<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulatorUjianVisual extends Model
{
    use HasFactory;
    public $table = 'simulasi_ujian_visual';
    protected $guarded = ['id'];
}
