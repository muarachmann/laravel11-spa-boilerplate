<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->seedData();
    }

    /**
     * Seeds database.
     * @return void
     */
    public function seedData(): void
    {
        $this->command->info("Seeding Tables 🌱");
        $this->call(LaratrustSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->command->info("Seeding Completed! 🤩");
    }
}
