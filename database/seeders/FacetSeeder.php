<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class FacetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facets = [
            ["code" => "a1", "deskripsi" => "trust"],
            ["code" => "a2", "deskripsi" => "straightforwardness"],
            ["code" => "a3", "deskripsi" => "altruism"],
            ["code" => "a4", "deskripsi" => "compliance"],
            ["code" => "a5", "deskripsi" => "modesty"],
            ["code" => "a6", "deskripsi" => "tender-mindedness"],
            ["code" => "c1", "deskripsi" => "competence"],
            ["code" => "c2", "deskripsi" => "order"],
            ["code" => "c3", "deskripsi" => "dutifulness"],
            ["code" => "c4", "deskripsi" => "achievement striving"],
            ["code" => "c5", "deskripsi" => "self-discipline"],
            ["code" => "c6", "deskripsi" => "deliberation"],
            ["code" => "e1", "deskripsi" => "warmth"],
            ["code" => "e2", "deskripsi" => "gregariousness"],
            ["code" => "e3", "deskripsi" => "assertiveness"],
            ["code" => "e4", "deskripsi" => "activity"],
            ["code" => "e5", "deskripsi" => "excitement seeking"],
            ["code" => "e6", "deskripsi" => "positive emotions"],
            ["code" => "n1", "deskripsi" => "anxiety"],
            ["code" => "n2", "deskripsi" => "angry hostility"],
            ["code" => "n3", "deskripsi" => "depression"],
            ["code" => "n4", "deskripsi" => "self consciousness"],
            ["code" => "n5", "deskripsi" => "impulsiveness"],
            ["code" => "n6", "deskripsi" => "vulnerability"],
            ["code" => "o1", "deskripsi" => "fantasy"],
            ["code" => "o2", "deskripsi" => "aesthetic"],
            ["code" => "o3", "deskripsi" => "feelings"],
            ["code" => "o4", "deskripsi" => "actions"],
            ["code" => "o5", "deskripsi" => "ideas"],
            ["code" => "o6", "deskripsi" => "values"],
        ];

        DB::table('facets')->insert($facets);
    }
}
// php artisan db:seed --class=FacetSeeder
