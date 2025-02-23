<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailEssay extends Model
{
    public $table = 'detail_essay';
    // Disable the model timestamps
    public $timestamps = false;
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = [
        'jawabanEssay', 
    ];

    // Relasi Ke Ujian
    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    // Relasi Ke JawabanEssay
    public function jawabanEssay()
    {
        return $this->hasMany(JawabanEssay::class, 'detail_essay_id', 'id');
    }
}
