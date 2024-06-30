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

        $users = [
            [
                'name' => 'Chharng Chhit',
                'email' => 'chharngchhit@gmail.com',
                'phone' => '085720085',
                'avatar' => 'pos/user/ChharngChhit.png',
                'password' => bcrypt('123456'),
                'users_type' => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name' => 'Kang Eangchheang',
                'email' => 'Eangchheang@gmail.com',
                'phone' => '085720086',
                'avatar' => 'pos/user/Eangchheang.png',
                'password' => bcrypt('123456'),
                'users_type' => 2,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name' => 'Ek Moniroth',
                'email' => 'Moniroth@gmail.com',
                'phone' => '085720088',
                'avatar' => 'pos/user/user.png',
                'password' => bcrypt('123456'),
                'users_type' => 3,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'name' => 'Doung Dariya',
                'email' => 'Dariya@gmail.com',
                'phone' => '088720072',
                'avatar' => 'pos/user/Dariya.png',
                'password' => bcrypt('123456'),
                'users_type' => 3,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
