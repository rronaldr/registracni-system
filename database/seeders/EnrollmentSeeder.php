<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use function random_int;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('enrollments')->insert([
            'user_id' => 2,
            'date_id' => 1,
            'state' => 1,
            'c_fields' => '{"name": {"value":"name1"}, "gender": {"value": "male"}}',
            'created_at' => Carbon::now()->subMinutes(random_int(0, 55)),
        ]);

        DB::table('enrollments')->insert([
            'user_id' => 3,
            'date_id' => 1,
            'state' => 1,
            'c_fields' => '{"name": {"value":"name1"}, "gender": {"value": "female"}}',
            'created_at' => Carbon::now()->subMinutes(random_int(0, 55)),
        ]);
        DB::table('enrollments')->insert([
            'user_id' => 4,
            'date_id' => 1,
            'state' => 1,
            'c_fields' => '{"name": {"value":"name1"}, "gender": {"value": "male"}}',
            'created_at' => Carbon::now()->subMinutes(random_int(0, 55)),
        ]);
        DB::table('enrollments')->insert([
            'user_id' => 5,
            'date_id' => 1,
            'state' => 1,
            'c_fields' => '{"name": {"value":"name1"}, "gender": {"value": "male"}}',
            'created_at' => Carbon::now()->subMinutes(random_int(0, 55)),
        ]);
        DB::table('enrollments')->insert([
            'user_id' => 6,
            'date_id' => 1,
            'state' => 1,
            'c_fields' => '{"name": {"value":"name1"}, "gender": {"value": "male"}}',
            'created_at' => Carbon::now()->subMinutes(random_int(0, 55)),
        ]);
        DB::table('enrollments')->insert([
            'user_id' => 2,
            'date_id' => 2,
            'state' => 1,
            'c_fields' => '{"name": {"value":"name1"}, "gender": {"value": "male"}}',
            'created_at' => Carbon::now()->subMinutes(random_int(0, 55)),
        ]);

        DB::table('enrollments')->insert([
            'user_id' => 3,
            'date_id' => 2,
            'state' => 1,
            'c_fields' => '{"name": {"value":"name1"}, "gender": {"value": "male"}}',
            'created_at' => Carbon::now()->subMinutes(random_int(0, 55)),
        ]);
        DB::table('enrollments')->insert([
            'user_id' => 4,
            'date_id' => 2,
            'state' => 1,
            'c_fields' => '{"name": {"value":"name1"}, "gender": {"value": "male"}}',
            'created_at' => Carbon::now()->subMinutes(random_int(0, 55)),
        ]);

    }
}
