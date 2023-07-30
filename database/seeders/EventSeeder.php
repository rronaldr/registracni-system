<?php

namespace Database\Seeders;

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
            'template_id' => 1,
            'name' => 'Seeder name',
            'subtitle' => 'Seeder subtitle',
            'type' => 1,
            'description' => 'Seeder description lorem ipsum dolor',
            'status' => 'draft',
            'c_fields' => '{"name":{"label":"Jméno","type":"text","default":null,"required":true},"gender":{"label":"Pohlaví","type":"select","options":[{"text":"mu\u017e","value":"man"},{"text":"\u017eena","value":"female"}],"default":"male","required":true}}',
        ]);
    }
}

