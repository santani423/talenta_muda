<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanEssay extends Model
{
    public $table = 'jawaban_essays';
    use HasFactory;
    protected $guarded = ['id'];
}
