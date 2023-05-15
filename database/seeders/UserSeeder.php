<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'       => 'admin',
                'username'   => 'admin',
                'is_admin'   => 1,
                'email'      => 'admin@mail.com',
                'password'   => Hash::make('admin'),
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            ],
            [
                'name'       => 'user',
                'username'   => 'user',
                'is_admin'   => 0,
                'email'      => 'user@user.com',
                'password'   => Hash::make('user'),
                'created_at' => Date::now(),
                'updated_at' => Date::now(),
            ],
        ];

        foreach ($data as $user) {
            $param = [
                'email'     => $user['email'],
                'username'  => $user['username'],
            ];
            DB::table('users')->updateOrInsert($param, $user);
        }
    }
}
