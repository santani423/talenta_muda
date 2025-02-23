<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgSiswa extends Model
{
    public $table = 'pg_siswa';
    // Disable the model timestamps
    public $timestamps = false;
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['jawaban', 'nilai'];
    protected $with = ['detailujian','jawaban','ujian'];

    // Relasi ke Detail Ujian
    public function detailujian()
    {
        return $this->belongsTo(DetailUjian::class,'detail_ujian_id', 'id');
    }
    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'kode', 'kode')->select(['kode', 'nama as nama_ujian']);
    }

    // Relasi ke WaktuUjian
    public function waktuujian()
    {
        $this->belongsTo(WaktuUjian::class, 'siswa_id', 'siswa_id');
    }

    // Relasi ke DetailJawaban
    public function detailjawaban()
    {
        return $this->hasOne(DetailUjian::class, 'id', 'detail_ujian_id');
    }
    public function jawaban()
    {
        return $this->hasOne(DetailUjian::class, 'id', 'detail_ujian_id');
    }

    public function updateNilai()
    {
        // Load the jawaban relationship
     
        // Get the related DetailUjian model
        $detailUjian = $this->belongsTo(DetailUjian::class,'detail_ujian_id', 'id')->get();
     
        // Check if nilai is null
        if (is_null($this->nilai)) {
            // Compare jawaban from PgSiswa with jawaban from DetailUjian
            if (strtolower('a') == strtolower($detailUjian->jawaban)) {
                // Update nilai to 1
                $this->nilai = 1;
                $this->save();
            }
        }
    }
}
