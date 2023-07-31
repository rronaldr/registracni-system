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
            'template_id' => 1,
            'name' => 'Název události',
            'subtitle' => 'Podtitulek události',
            'type' => 1,
            'status' => 'draft',
            'date_start_cache' => Carbon::now()->startOfMonth()->addHours(12),
            'date_end_cache' => Carbon::now()->startOfMonth()->addDays(2)->addHours(3)->addHours(11)->addMinutes(15),
            'c_fields' => '[{"label":"Jméno","type":"text","default":null,"required":true,"value":"name"},{"label":"Pohlaví","type":"select","options":[{"text":"mu\u017e","value":"man"},{"text":"\u017eena","value":"female"}],"default":"male","required":true}]',
            'description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque pretium lectus id turpis. Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat. Praesent dapibus. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Curabitur vitae diam non enim vestibulum interdum. Etiam posuere lacus quis dolor. Aliquam id dolor. Pellentesque arcu. Duis sapien nunc, commodo et, interdum suscipit, sollicitudin et, dolor. Integer imperdiet lectus quis justo.',
        ]);
    }
}

