<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisJawabanKuesioner extends Model
{
    public $table = 'jenis_jawaban_kuesioner';
    use HasFactory;
    protected $guarded = ['id'];
}
