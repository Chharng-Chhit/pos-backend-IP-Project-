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
            ]
        );

    }
}
