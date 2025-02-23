<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJawabanKuesioner extends Model
{
    public $table = 'detail_jawaban_kuesioner';
    use HasFactory;
    protected $guarded = ['id'];
}
