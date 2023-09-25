<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            EventSeeder::class,
            DateSeeder::class,
            UserSeeder::class,
            EnrollmentSeeder::class,
            TemplateSeeder::class,
            BlacklistSeeder::class,
            PermissionsSeeder::class,
        ]);
    }
}
