<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailVisual extends Model
{
    public $table = 'detail_visual';
    use HasFactory;
    protected $guarded = ['id'];
}
