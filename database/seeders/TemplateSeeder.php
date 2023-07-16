<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('templates')->insert([
            'name' => 'Seeder template',
            'approved' => 1,
            'params' => '["name", "faculty"]',
            'html' => '<!DOCTYPE html>
                        <html lang="cs">
                          <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <meta http-equiv="X-UA-Compatible" content="ie=edge">
                            <title>HTML 5 Boilerplate</title>
                          </head>
                          <body>
                            <div id="customContent">I am {{ $name }} from {{ $faculty }} with email {{ $user->email }}</div>
                          </body>
                        </html>',
        ]);
        DB::table('templates')->insert([
            'name' => 'Seeder template not approved',
            'approved' => 0,
            'html' => '<!DOCTYPE html>
                        <html lang="cs">
                          <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <meta http-equiv="X-UA-Compatible" content="ie=edge">
                            <title>HTML 5 Boilerplate</title>
                          </head>
                          <body>
                            <div id="customContent"></div>
                          </body>
                        </html>',
        ]);
    }
}
