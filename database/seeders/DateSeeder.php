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
            'event_id' => 1,
            'location' => 'Seeder místnost SB112',
            'date_start' => Carbon::now()->startOfMonth()->addHours(12),
            'date_end' => Carbon::now()->startOfMonth()->addHours(13)->addMinutes(30),
            'enrollment_start' => Carbon::now(),
            'enrollment_end' => Carbon::now()->startOfMonth(),
            'withdraw_end' => Carbon::now()->startOfMonth(),
            'capacity' => 20,
            'substitute' => false,
        ]);

        DB::table('dates')->insert([
            'event_id' => 1,
            'location' => 'Seeder místnost RB101',
            'date_start' => Carbon::now()->startOfMonth()->addDays(2)->addHours(9),
            'date_end' => Carbon::now()->startOfMonth()->addDays(2)->addHours(3)->addHours(11)->addMinutes(15),
            'enrollment_start' => Carbon::now(),
            'enrollment_end' => Carbon::now()->startOfMonth()->addDays(2),
            'withdraw_end' => Carbon::now()->startOfMonth()->addDays(2),
            'capacity' => 100,
            'substitute' => false,
        ]);

        DB::table('dates')->insert([
            'event_id' => 1,
            'location' => 'Seeder místnost RB210',
            'date_start' => Carbon::now()->startOfMonth()->addDays(35),
            'date_end' => Carbon::now()->startOfMonth()->addDays(35)->addHours(3),
            'enrollment_start' => Carbon::now(),
            'enrollment_end' => Carbon::now()->startOfMonth()->addDays(35),
            'withdraw_end' => Carbon::now()->startOfMonth()->addDays(35),
            'capacity' => 8,
            'name' => 'Název termínu',
            'substitute' => true,
        ]);

    }
}
