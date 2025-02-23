<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Domain;
use App\Models\DomainFacet;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'deskripsi' => 'NEUROTICISM',
                'kode' => 'D1',
                'domainFacet' => 'n'
            ],
            [
                'deskripsi' => 'EXTRAVERSION',
                'kode' => 'D2',
                'domainFacet' => 'e'
            ],
            [
                'deskripsi' => 'OPENESS TO EXPERIENCE',
                'kode' => 'D3',
                'domainFacet' => 'o'
            ],
            [
                'deskripsi' => 'AGREEABLENESS',
                'kode' => 'D4',
                'domainFacet' => 'a'
            ],
            [
                'deskripsi' => 'CONSCIENTIOUSNESS',
                'kode' => 'D5',
                'domainFacet' => 'c'
            ], 
        ];

        foreach ($data as $key => $value) {
          $domain=  Domain::create([
                'deskripsi' => $value['deskripsi'],
                'kode' => $value['kode'],
                // 'domainFacet' => $value['domainFacet']
            ]);
            for ($i=0; $i < 6; $i++) { 
                $domainFacet = $value['domainFacet']; 
                DomainFacet::create([
                    'domain_id' => $domain->id,
                    'kode_facet' => $domainFacet.($i+1),
                ]);
            }
        }
    }
}
