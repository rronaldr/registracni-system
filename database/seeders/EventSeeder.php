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
            'id' => 25,
            'name' => 'Seeder name',
            'subtitle' => 'Seeder subtitle',
            'type' => 1,
            'description' => 'Seeder description lorem ipsum dolor',
            'status' => 'draft',
            'c_fields' => '{"name":{"type":"text","default":null,"required":true},"gender":{"type":"select","options":[{"text":"mu\u017e","value":"man"},{"text":"\u017eena","value":"female"}],"default":"male","required":true}}',
            'hidden' => false,
            'dates_cache' => '4.5.2023 - 14.5.2023',
        ]);
    }
}

