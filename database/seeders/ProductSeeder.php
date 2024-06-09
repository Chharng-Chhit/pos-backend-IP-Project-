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

        $image = [
            'https://images.pexels.com/photos/3819969/pexels-photo-3819969.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
            'https://images.pexels.com/photos/212303/pexels-photo-212303.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
            'https://images.pexels.com/photos/812868/pexels-photo-812868.jpeg?auto=compress&cs=tinysrgb&w=600'
        ];

        // Seed Product
        for ($i = 0; $i <100; $i++) {
            DB::table('product')->insert([
                "type_id"       => rand(1,4),
                "name"          => Str::random(10),
                "code"          => Str::random(5),
                "image"         => $image[rand(0,2)],
                "unit_price"    => rand(1, 20)*1000,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
        ]);
        }
    }
}
