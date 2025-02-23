<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MergeUjian extends Model
{
    use HasFactory;

    protected $table = 'merge_ujian';  // Table name
    protected $guarded = ['id'];       // Guarded fields

    /**
     * Relationship to WaktuUjian model
     * A MergeUjian can have multiple WaktuUjian records with the same kode
     */
    public function waktuUjian()
    {
        return $this->hasMany(WaktuUjian::class, 'kode', 'kode');
    }
}
