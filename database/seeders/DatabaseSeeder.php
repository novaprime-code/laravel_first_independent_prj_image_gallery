<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // User::truncate();

        // $users = [
        //     [
        //         'name' => 'Super Admin',
        //         'email' => 'admin1@gmail.com',
        //         'password' => '12345678',
        //     ],
        //     [
        //         'name' => 'Bacha Admin',
        //         'email' => 'bcadmin@gmail.com',
        //         'password' => '12345678',
        //     ],
        //     [
        //         'name' => 'Project Admin',
        //         'email' => 'projectadmin@gmail.com',
        //         'password' => '12345678',
        //     ],
        //     [
        //         'name' => 'Client Admin',
        //         'email' => 'clientadmin@gmail.com',
        //         'password' => '12345678',
        //     ],
        // ];

        // User::insert($users);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);
        // DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10) . '@gmail.com',
        //     'password' => Hash::make('12345678'),
        // ]);

        // for ($i = 0; $i < 5; $i++) {
        //     // $usser = rand(0, 99);
        //     DB::table('users')->insert([
        //         'name' => 'user' . $i,
        //         'email' => 'user' . $i . '@mail.com',
        //         'password' => Hash::make('12345678'),
        //     ]);
        // }
    }
}
