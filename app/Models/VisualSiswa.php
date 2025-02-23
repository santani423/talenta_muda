<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisualSiswa extends Model
{
    public $table = 'visual_siswa';

    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['detailVisual','ujian'];
    // Relasi ke Detail Ujian
    public function detailVisual()
    {
        return $this->belongsTo(DetailVisual::class, 'detail_visual_id');
    }
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'kode', 'kode')->select(['kode', 'nama as nama_ujian']);
    }
}
