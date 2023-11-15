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
            'xname' => 'rebr00',
            'first_name' => 'Ronald',
            'last_name' => 'Rebernigg',
            'email' => 'rebr00@vse.cz',
            'password' => 'shibboleth'
        ]);

        DB::table('users')->insert([
            'xname' => 'xvojs03',
            'first_name' => 'Stanislav',
            'last_name' => 'Vojíř',
            'email' => 'stanislav.vojir@vse.cz',
            'password' => 'shibboleth'
        ]);

        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'xname' => sprintf('johd0%d', $i),
                'first_name' => 'John',
                'last_name' => sprintf('Doe %d', $i),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
