<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('dates')->insert([
            'event_id' => 25,
            'location' => 'Seeder místnost SB112',
            'date_start' => Carbon::now()->addDays(10),
            'date_end' => Carbon::now()->addDays(10)->addHours(3),
            'enrollment_start' => Carbon::now(),
            'enrollment_end' => Carbon::now()->addDays(5),
            'withdraw_end' => Carbon::now()->addDays(5),
            'capacity' => 20,
            'substitute' => false,
        ]);

        DB::table('dates')->insert([
            'event_id' => 25,
            'location' => 'Seeder místnost RB101',
            'date_start' => Carbon::now()->addDays(20),
            'date_end' => Carbon::now()->addDays(20)->addHours(3),
            'enrollment_start' => Carbon::now(),
            'enrollment_end' => Carbon::now()->addDays(10),
            'withdraw_end' => Carbon::now()->addDays(10),
            'capacity' => 100,
            'substitute' => false,
        ]);

        DB::table('dates')->insert([
            'event_id' => 25,
            'location' => 'Seeder místnost RB210',
            'date_start' => Carbon::now()->addDays(15),
            'date_end' => Carbon::now()->addDays(15)->addHours(3),
            'enrollment_start' => Carbon::now(),
            'enrollment_end' => Carbon::now()->addDays(10),
            'withdraw_end' => Carbon::now()->addDays(10),
            'capacity' => 8,
            'name' => 'Název termínu',
            'substitute' => true,
        ]);

    }
}
