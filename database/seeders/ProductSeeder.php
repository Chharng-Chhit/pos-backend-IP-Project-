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
                    'name'          => 'Beverage',
                    'icon'         => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name'          => 'Dairy',
                    'icon'         => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name'          => 'Stationairy',
                    'icon'         => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name'          => 'Meat',
                    'icon'         => '',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name'          => 'Hygiene',
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
        // for ($i = 0; $i <100; $i++) {
        //     DB::table('product')->insert([
        //         "type_id"       => rand(1,4),
        //         "name"          => Str::random(10),
        //         "code"          => Str::random(5),
        //         "image"         => $image[rand(0,2)],
        //         "unit_price"    => rand(1, 20)*1000,
        //         "created_at"    => Carbon::now(),
        //         "updated_at"    => Carbon::now()
        // ]);
        // }

        DB::table('product')->insert(
            [
                "type_id"       => 1,
                "name"          => 'Coca Cola 350ml',
                "code"          => 'B0001',
                "image"         => 'pos/product/Coca Cola.png',
                "unit_price"    => 1.5,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Dutch Mill Pasturized Low Fat Milk',
                "code"          => 'D0001',
                "image"         => 'pos/product/Fat Milk.png',
                "unit_price"    => 3.5,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'E&V Unsalted Butter 200G',
                "code"          => 'D0002',
                "image"         => 'pos/product/Unsalted Butter.png',
                "unit_price"    => 2.25,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Angkor beer 330ml',
                "code"          => 'A0001',
                "image"         => 'pos/product/Angkor beer.png',
                "unit_price"    => 1.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 5,
                "name"          => 'Clear Men Shampoo Scalp Legend by ',
                "code"          => 'C0001',
                "image"         => 'pos/product/Clear Men.png',
                "unit_price"    => 1.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 3,
                "name"          => 'Giraffe Spiral Notebook A5',
                "code"          => 'S0001',
                "image"         => 'pos/product/Notebook.png',
                "unit_price"    => 0.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Carne Meats Raw Ribeye Steak',
                "code"          => 'S0001',
                "image"         => 'pos/product/Raw Meats.png',
                "unit_price"    => 0.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'SAMYANG Samyang Hot ',
                "code"          => 'S0002',
                "image"         => 'pos/product/SamYang.png',
                "unit_price"    => 0.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 1,
                "name"          => 'Coca Cola 350ml',
                "code"          => 'B0001',
                "image"         => 'pos/product/Coca Cola.png',
                "unit_price"    => 1.5,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Dutch Mill Pasturized Low Fat Milk',
                "code"          => 'D0001',
                "image"         => 'pos/product/Fat Milk.png',
                "unit_price"    => 3.5,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'E&V Unsalted Butter 200G',
                "code"          => 'D0002',
                "image"         => 'pos/product/Unsalted Butter.png',
                "unit_price"    => 2.25,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Angkor beer 330ml',
                "code"          => 'A0001',
                "image"         => 'pos/product/Angkor beer.png',
                "unit_price"    => 1.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 5,
                "name"          => 'Clear Men Shampoo Scalp Legend by ',
                "code"          => 'C0001',
                "image"         => 'pos/product/Clear Men.png',
                "unit_price"    => 1.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 3,
                "name"          => 'Giraffe Spiral Notebook A5',
                "code"          => 'S0001',
                "image"         => 'pos/product/Notebook.png',
                "unit_price"    => 0.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Carne Meats Raw Ribeye Steak',
                "code"          => 'S0001',
                "image"         => 'pos/product/Raw Meats.png',
                "unit_price"    => 0.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'SAMYANG Samyang Hot ',
                "code"          => 'S0002',
                "image"         => 'pos/product/SamYang.png',
                "unit_price"    => 0.95,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
        );
    }
}
