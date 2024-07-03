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

        $products = [
            [
                "type_id"       => 1,
                "name"          => 'Coca Cola 350ml',
                "code"          => 'B0009',
                "image"         => 'pos/product/Coca Cola.png',
                "unit_price"    => 1.5,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Dutch Mill Pasturized Low Fat Milk',
                "code"          => 'D0001',
                "image"         => 'pos/product/Fat Milk.png',
                "unit_price"    => 3.5,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'E&V Unsalted Butter 200G',
                "code"          => 'D0002',
                "image"         => 'pos/product/Unsalted Butter.png',
                "unit_price"    => 2.25,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Angkor beer 330ml',
                "code"          => 'A0010',
                "image"         => 'pos/product/Angkor beer.png',
                "unit_price"    => 1.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 5,
                "name"          => 'Clear Men Shampoo Scalp Legend by ',
                "code"          => 'C0002',
                "image"         => 'pos/product/Clear Men.png',
                "unit_price"    => 1.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 3,
                "name"          => 'Giraffe Spiral Notebook A5',
                "code"          => 'S0002',
                "image"         => 'pos/product/Notebook.png',
                "unit_price"    => 0.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Carne Meats Raw Ribeye Steak',
                "code"          => 'S0003',
                "image"         => 'pos/product/Raw Meats.png',
                "unit_price"    => 0.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'SAMYANG Samyang Hot ',
                "code"          => 'S0004',
                "image"         => 'pos/product/SamYang.png',
                "unit_price"    => 0.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 1,
                "name"          => 'Coca Cola 350ml',
                "code"          => 'B0004',
                "image"         => 'pos/product/Coca Cola1.png',
                "unit_price"    => 1.5,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Dutch Mill Pasturized Low Fat Milk',
                "code"          => 'D0004',
                "image"         => 'pos/product/Fat Milk1.png',
                "unit_price"    => 3.5,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'E&V Unsalted Butter 200G',
                "code"          => 'D0005',
                "image"         => 'pos/product/Unsalted Butter1.png',
                "unit_price"    => 2.25,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Angkor beer 330ml',
                "code"          => 'A0006',
                "image"         => 'pos/product/Angkor beer1.png',
                "unit_price"    => 1.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 5,
                "name"          => 'Clear Men Shampoo Scalp Legend by ',
                "code"          => 'C0007',
                "image"         => 'pos/product/Clear Men1.png',
                "unit_price"    => 1.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 3,
                "name"          => 'Giraffe Spiral Notebook A5',
                "code"          => 'S0008',
                "image"         => 'pos/product/Notebook1.png',
                "unit_price"    => 0.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'Carne Meats Raw Ribeye Steak',
                "code"          => 'S0009',
                "image"         => 'pos/product/Raw Meats1.png',
                "unit_price"    => 0.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
            [
                "type_id"       => 2,
                "name"          => 'SAMYANG Samyang Hot ',
                "code"          => 'S0010',
                "image"         => 'pos/product/SamYang1.png',
                "unit_price"    => 0.95,
                "in_stock"      => 200,
                "created_at"    => Carbon::now(),
                "updated_at"    => Carbon::now()
            ],
        ];

        // Seed Product
        // for ($i = 0; $i < 100; $i++) {
        //     DB::table('product')->insert($products);
        // }
        foreach ($products as $product) {
            DB::table('product')->insert($product);
        }
    }
}
