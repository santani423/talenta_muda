<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuesionerSiswa extends Model
{
    public $table = 'kuesioner_siswa'; 
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['detailJawabanKuisoner','detailKuisoner','facet'];

     // relasi Ke WaktuUjian
    public function detailJawabanKuisoner()
    {
        return $this->hasMany(DetailJawabanKuesioner::class, 'id', 'detail_jawaban_kuesioner_id');
    }
    public function detailKuisoner()
    {
        return $this->hasMany(DetailKuisoner::class, 'id', 'detail_kuisoner');
    }
     // relasi Ke WaktuUjian
    public function nilaiSiswa()
    {
        return $this->hasMany(DetailJawabanKuesioner::class, 'id', 'detail_jawaban_kuesioner_id');
    }
    public function facet()
    {
        return $this->hasMany(DetailKuisonerFacet::class, 'detail_kuisoner_id', 'detail_kuisoner');
    }
     


}
