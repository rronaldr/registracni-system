<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('events')->insert([
            'id' => 1,
            'user_id' => 1,
            'template_id' => 2,
            'calendar_id' => 4719,
            'name' => 'Název události',
            'subtitle' => 'Podtitulek události',
            'type' => 1,
            'status' => 2,
            'contact_person' => 'Ronald Rebernigg',
            'contact_email' => 'rebr00@vse.cz',
            'user_group' => 1,
            'date_start_cache' => Carbon::now()->startOfMonth()->addHours(12),
            'date_end_cache' => Carbon::now()->startOfMonth()->addDays(20)->addHours(3)->addHours(11)->addMinutes(15),
            'c_fields' => '[
                {"id":1,"label":"Jméno","type":"text","default":null,"required":true,"value":"name"},
                {"id":2,"label":"Pohlaví","type":"select","options":"Muž,Žena","default":"male","required":true, "value":"gender"}
            ]',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

