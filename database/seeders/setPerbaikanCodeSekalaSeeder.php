<?php

namespace Database\Seeders;

use App\Models\DetailKuisoner;
use App\Models\DetailKuisonerSekala;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class setPerbaikanCodeSekalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = DetailKuisonerSekala::get();
        foreach ($data as $item) {
           if($item->kode_sekala == "TRT/TRT1") {
                DetailKuisonerSekala::where('id', $item->id)->update([
                    'kode_sekala' => 'TRT1'
                ]);
            }
           if($item->kode_sekala == "TRT/TRT2") {
                DetailKuisonerSekala::where('id', $item->id)->update([
                    'kode_sekala' => 'TRT2'
                ]);
            }
        }
    }
}
