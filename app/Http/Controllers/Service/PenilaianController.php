<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function Kuisoner($jawaba,$detail_kuisoner_id,$item)
    {
        return view('service.penilaian.kuisoner', compact('detail_kuisoner'));
    }
     
}
