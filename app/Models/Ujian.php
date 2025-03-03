<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    public $table = 'ujian';
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = [
        'detailujian',
        'detailVisual',
        'detailKuisoner',
        'detailessay',
        'detailPg',
        'simulasiPg',
        'simulasiVisual'
    ];

    // Relasi Ke Guru
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    // Relasi Ke Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
    // relasi Ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    // relasi Ke WaktuUjian
    public function waktuujian()
    {
        return $this->hasMany(WaktuUjian::class, 'kode', 'kode');
    }

    // relasi Ke DetailUjian
    public function detailujian()
    {
        return $this->hasMany(DetailUjian::class, 'kode', 'kode');
    }

    public function detailVisual()
    {
        return $this->hasMany(DetailVisual::class, 'kode', 'kode');
    }

    public function detailKuisoner()
    {
        return $this->hasMany(DetailKuisoner::class, 'kode', 'kode');
    }

    public function detailPg()
    {
        return $this->hasMany(DetailUjian::class, 'kode', 'kode');
    }
    public function simulasiPg()
    {
        return $this->hasMany(SimulatorUjianPg::class, 'kode', 'kode');
    }
    public function simulasiVisual()
    {
        return $this->hasMany(SimulatorUjianVisual::class, 'kode', 'kode');
    }



    // relasi Ke DetailEssay
    public function detailessay()
    {
        return $this->hasMany(DetailEssay::class, 'kode', 'kode');
    }

    // DEFAULT KEY DI UBAH JADI KODE BUKAN ID LAGI
    public function getRouteKeyName()
    {
        return 'kode';
    }
}
