<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  Seed Product Type
        DB::table('category')->insert(
            [
                [
                    'name'          => 'Fast Food',
                    'icon'         => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name'          => 'Rice',
                    'icon'         => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name'          => 'Soup',
                    'icon'         => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name'          => 'Drink',
                    'icon'         => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],

            ]
        );

        // Seed Product
        for ($i=0; $i<100; $i++){
            DB::table('product')->insert(
                [
                    "type_id"       => rand(1,4),
                    "name"          => Str::random(10),
                    "code"          => Str::random(5),
                    "image"         => '',
                    "unit_price"    => rand(1, 20)*1000,
                    "created_at"    => Carbon::now(),
                    "updated_at"    => Carbon::now()
                ]);
        }
    }
}
