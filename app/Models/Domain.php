<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['domainFacet'];
    
    public function domainFacet()
    {
        return $this->hasMany(DomainFacet::class, 'domain_id', 'id');
    }
}
