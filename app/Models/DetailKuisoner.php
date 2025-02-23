<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKuisoner extends Model
{
    public $table = 'detail_kuisoner';
    use HasFactory;
    protected $guarded = ['id']; 
    protected $with = ['detailJawabanKuisoner','facet'];

    // relasi Ke WaktuUjian
    public function detailJawabanKuisoner()
    {
        return $this->hasMany(DetailJawabanKuesioner::class, 'jenis_jawaban_kuesioner_id', 'jenis_jawaban_kuesioner_id');
    }
    public function facet()
    {
        return $this->hasMany(DetailKuisonerFacet::class, 'detail_kuisoner_id', 'id');
    }
}
