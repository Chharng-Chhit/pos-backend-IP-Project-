<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('users_type')->insert(
            [
                [
                    'name'          => 'Admin',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name' => 'Staff',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name' => 'Customer',
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ]
            ]
        );

        DB::table('users')->insert(
            [
                [
                    'name' => 'Chharng Chhit',
                    'email' => 'admin@gmail.com',
                    'phone' => '12345671',
                    'password' => bcrypt('123456'),
                    'users_type' => 1,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name' => 'Chharng Chhit',
                    'email' => 'admin1@gmail.com',
                    'phone' => '12345672',
                    'password' => bcrypt('123456'),
                    'users_type' => 2,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name' => 'Chharng Chhit',
                    'email' => 'admin2@gmail.com',
                    'phone' => '12345673',
                    'password' => bcrypt('123456'),
                    'users_type' => 3,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ],
                [
                    'name' => 'Chharng Chhit',
                    'email' => 'admin4@gmail.com',
                    'phone' => '12345674',
                    'password' => bcrypt('123456'),
                    'users_type' => 3,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ]
            ]
                );

    }
}
