<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name' => 'Ronald',
            'last_name' => 'Rebernigg',
            'email' => 'ronald.rebernigg@gmail.com',
            'password' => Hash::make('testtest'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'first_name' => 'John',
                'last_name' => sprintf('Doe %d', $i++),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
